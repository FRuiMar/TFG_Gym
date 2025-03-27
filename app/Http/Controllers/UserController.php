<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;




class UserController extends Controller
{
    // Mostrar lista de usuarios
    public function index()
    {
        $users = User::with('membership')->get();
        return view('users.index', compact('users'));
    }

    // Mostrar detalles de un usuario específico
    public function show(User $user)
    {
        $user->load('membership', 'activities');
        return view('users.show', compact('user'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $memberships = Membership::all();
        return view('users.create', compact('memberships'));
    }

    // Guardar un nuevo usuario
    public function store(UserStoreRequest $request)
    {
        try {

            $validated = $request->validated();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('users', 'public');
                $validated['image'] = $path;
            }

            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);
            return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de base de datos (duplicados, restricciones, etc)
            Log::error('Error al crear usuario (DB): ' . $e->getMessage());
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode == 1062) { // Código de error de duplicate entry
                return back()->withInput()->with('error', 'Ya existe un usuario con ese DNI o correo electrónico.');
            }

            if ($errorCode == 1265) { // Código para data truncated
                return back()->withInput()->with('error', 'El rol seleccionado no es válido. Debe ser ADMIN o NORMAL.');
            }

            // Otros errores de base de datos
            return back()->withInput()->with('error', 'Error de base de datos al crear el usuario.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Los errores de validación ya son manejados por Laravel, pero podemos personalizarlos
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error al crear usuario: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ha ocurrido un error al crear el usuario.');
        }
    }

    // Mostrar formulario de edición
    public function edit(User $user)
    {
        $memberships = Membership::all();
        return view('users.edit', compact('user', 'memberships'));
    }

    // Actualizar usuario
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $validated = $request->validated();

            // Manejar la subida de imagen si existe
            if ($request->hasFile('image')) {
                // Eliminar imagen anterior si existe
                if ($user->image && Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                }

                $path = $request->file('image')->store('users', 'public');
                $validated['image'] = $path;
            }

            if (isset($validated['password']) && $validated['password']) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);
            return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de base de datos
            Log::error('Error al actualizar usuario (DB): ' . $e->getMessage());
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode == 1062) { // Duplicate entry
                return back()->withInput()->with('error', 'Ya existe un usuario con ese DNI o correo electrónico.');
            }

            return back()->withInput()->with('error', 'Error de base de datos al actualizar el usuario.');
        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error al actualizar usuario: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ha ocurrido un error al actualizar el usuario.');
        }
    }

    // Eliminar usuario
    public function destroy(User $user)
    {
        try {
            // Verificar si el usuario tiene relaciones importantes
            if ($user->activities()->count() > 0) {
                return back()->with('warning', 'No se puede eliminar el usuario porque tiene actividades asociadas.');
            }

            // Puedes agregar más verificaciones de relaciones según tu modelo

            // Eliminar la imagen si existe
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Error al eliminar usuario (DB): ' . $e->getMessage());

            // Comprobar si es un error de restricción de clave foránea
            if (str_contains($e->getMessage(), 'foreign key constraint fails')) {
                return back()->with('error', 'No se puede eliminar el usuario porque tiene relaciones en la base de datos.');
            }

            return back()->with('error', 'Error de base de datos al eliminar el usuario.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar usuario: ' . $e->getMessage());
            return back()->with('error', 'Ha ocurrido un error al eliminar el usuario.');
        }
    }




    public function myReservations()
    {
        // Obtiene el usuario autenticado con sus actividades cargadas

        //ORIGINAL
        //$user = User::with(['activities.trainer'])->find(Auth::id());

        //AÑADO ESTO.. PARA PROBAR.
        $user = User::with(['activities' => function ($query) {
            $query->withPivot('id', 'reservation_date'); // Cargar los datos de la tabla pivote
        }, 'activities.trainer'])->find(Auth::id());


        if (!$user) {
            return redirect()->route('login');
        }

        // Meto en cada reserva los datos pivot
        $reservations = $user->activities;

        // Agregamos esto para depuración que me está dando fallo. 
        foreach ($reservations as $reservation) {
            Log::info('Reservation: activity_id=' . $reservation->id . ', pivot_id=' . ($reservation->pivot->id ?? 'null'));
        }

        return view('users.reservation', compact('reservations'));
    }



    public function cancelReservation($reservationId)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Encontrar la reserva en la tabla pivot
        $reservation = DB::table('activity_user')
            ->where('id', $reservationId)
            ->where('user_id', Auth::id()) // Para seguridad, asegurarse de que la reserva pertenece al usuario
            ->first();

        if (!$reservation) {
            return redirect()->route('user.reservations')
                ->with('error', 'La reserva no existe o no tienes permiso para cancelarla.');
        }

        // Encontrar la información de la actividad para mostrarla en el mensaje de éxito
        $activity = Activity::find($reservation->activity_id);
        $activityName = $activity ? $activity->name : 'la actividad';

        // Eliminar la reserva
        DB::table('activity_user')
            ->where('id', $reservationId)
            ->delete();

        return redirect()->route('user.reservations')
            ->with('success', "Reserva para {$activityName} cancelada correctamente.");
    }



    public function adminReservations()
    {
        // Obtener todas las reservas a través de la relación entre User y Activity
        $users = User::with(['activities' => function ($query) {
            $query->withPivot('id', 'reservation_date');
            $query->with('trainer'); // Cargar el entrenador de cada actividad
        }])->get();

        $reservations = collect();

        foreach ($users as $user) {
            foreach ($user->activities as $activity) {
                $reservations->push((object)[
                    'reservation_id' => $activity->pivot->id,
                    'reservation_date' => $activity->pivot->reservation_date,
                    'activity_name' => $activity->name,
                    'schedule' => $activity->schedule,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'trainer_first_name' => optional($activity->trainer)->first_name,
                    'trainer_last_name' => optional($activity->trainer)->last_name,
                    'user_id' => $user->id
                ]);
            }
        }

        // Ordenar por fecha de reserva
        $reservations = $reservations->sortBy('reservation_date');

        return view('users.adminReservation', compact('reservations'));
    }


    public function adminCancelReservation($reservationId)
    {
        // Encontrar la reserva en la tabla pivot
        $reservation = DB::table('activity_user')
            ->where('id', $reservationId)
            ->first();

        if (!$reservation) {
            return redirect()->route('user.admin.reservations')
                ->with('error', 'La reserva no existe.');
        }

        // Encontrar la información de la actividad y del usuario
        $activity = Activity::find($reservation->activity_id);
        $user = User::find($reservation->user_id);

        $activityName = $activity ? $activity->name : 'la actividad';
        $userName = $user ? $user->name : 'el usuario';

        // Eliminar la reserva
        DB::table('activity_user')
            ->where('id', $reservationId)
            ->delete();

        return redirect()->route('user.admin.reservations')
            ->with('success', "Reserva de {$activityName} para {$userName} cancelada correctamente.");
    }
}
