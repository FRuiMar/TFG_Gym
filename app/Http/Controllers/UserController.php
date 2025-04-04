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
        // Antes: $users = User::with('membership')->get();
        // Ahora:
        $users = User::with(['membership', 'userMemberships' => function ($query) {
            $query->where('is_active', true)->latest();
        }])->get();

        return view('users.index', compact('users'));
    }


    // Mostrar detalles de un usuario específico
    public function show(User $user)
    {
        // Antes: $user->load('membership', 'activities');
        // Ahora:
        $user->load([
            'membership',
            'userMemberships' => function ($query) {
                $query->orderBy('start_date', 'desc');
            },
            'reservations' => function ($query) {
                $query->with(['classSession.activity', 'classSession.trainer']);
            }
        ]);

        return view('users.show', compact('user'));
    }



    // Mostrar formulario de creación
    public function create()
    {
        $memberships = Membership::where('activo', true)->get();
        return view('users.create', compact('memberships'));
    }



    // Guardar un nuevo usuario
    public function store(UserStoreRequest $request)
    {
        try {

            $validated = $request->validated();

            // Para la imagen
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('users', 'public');
                $validated['image'] = $path;
            }

            // Encriptamos la contraseña, si existe
            $validated['password'] = Hash::make($validated['password']);

            // -NUEVO-
            // Confirmo que los campos de entrenador son null si el role no es 'TRAINER'
            if (isset($validated['role']) && $validated['role'] !== 'TRAINER') {
                $validated['specialty_1'] = null;
                $validated['specialty_2'] = null;
            }


            //Creo el usuario /////PEEEEROOO lo guardo en una variable para luego usarla para el registro de la membresía
            $user = User::create($validated);


            // -NUEVO- para el registro de membresía, para el histórico
            // Si tiene membresía, crear el registro en user_memberships
            if (!empty($validated['membership_id'])) {
                $membership = Membership::find($validated['membership_id']);
                if ($membership) {
                    $user->userMemberships()->create([
                        'membership_id' => $validated['membership_id'],
                        'start_date' => now(),
                        'end_date' => now()->addMonths($membership->duracion_meses),
                        'payment_status' => 'paid',
                        'last_payment_date' => now(),
                        'next_payment_date' => now()->addMonths(1),
                        'amount_paid' => $membership->precio,
                        'is_active' => true,
                    ]);
                }
            }



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
        $memberships = Membership::where('activo', true)->get();
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


            // Encripto la contraseña, si existe
            if (isset($validated['password']) && $validated['password']) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }


            // Asegurarnos que los campos de entrenador son null si el role no es 'trainer'
            if (isset($validated['role']) && $validated['role'] !== 'trainer') {
                $validated['specialty_1'] = null;
                $validated['specialty_2'] = null;
            }

            // Verificar si hubo cambio de membresía
            $membershipChanged = isset($validated['membership_id']) &&
                $user->membership_id != $validated['membership_id'];

            // Actualizar usuario
            $user->update($validated);

            // Si cambió la membresía, actualizar historial
            if ($membershipChanged && !empty($validated['membership_id'])) {
                // Desactivar registro de membresía actual
                $user->userMemberships()->where('is_active', true)->update(['is_active' => false]);

                // Crear nuevo registro de membresía actual
                $membership = Membership::find($validated['membership_id']);
                if ($membership) {
                    $user->userMemberships()->create([
                        'membership_id' => $validated['membership_id'],
                        'start_date' => now(),
                        'end_date' => now()->addMonths($membership->duracion_meses),
                        'payment_status' => 'paid',
                        'last_payment_date' => now(),
                        'next_payment_date' => now()->addMonths(1),
                        'amount_paid' => $membership->precio,
                        'is_active' => true,
                    ]);
                }
            }

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
            // Verificar si el usuario tiene reservas activas
            $hasActiveReservations = $user->reservations()
                ->where('fecha', '>=', now())
                ->where('estado', 'confirmada')
                ->exists();

            if ($hasActiveReservations) {
                return back()->with('warning', 'No se puede eliminar el usuario porque tiene reservas activas.');
            }

            // Verificar si el usuario es un entrenador con sesiones programadas
            if ($user->role === 'trainer') {
                $hasScheduledSessions = $user->trainerSessions()
                    ->where('is_active', true)
                    ->exists();

                if ($hasScheduledSessions) {
                    return back()->with('warning', 'No se puede eliminar el entrenador porque tiene sesiones programadas.');
                }
            }

            // Eliminar la imagen si existe
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // Para borrado suave, puedes usar:
            $user->delete();

            return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar usuario: ' . $e->getMessage());
            return back()->with('error', 'Ha ocurrido un error al eliminar el usuario.');
        }
    }
}
