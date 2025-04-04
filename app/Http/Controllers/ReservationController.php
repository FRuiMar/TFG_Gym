<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Models\Reservation;
use App\Models\ClassSession;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'class_session_id' => 'required|exists:class_sessions,id',
                'fecha' => 'required|date|after_or_equal:today',
            ]);

            // Obtener usuario
            $userId = Auth::id();
            $user = User::find($userId);

            if (!$user) {
                return redirect()->back()->with('error', 'Usuario no encontrado.');
            }

            // Obtener la sesión de clase
            $classSession = ClassSession::with('activity')->findOrFail($request->class_session_id);

            // Verificar si ya está inscrito en esta sesión para esta fecha
            $existingReservation = Reservation::where('user_id', $userId)
                ->where('session_id', $classSession->id)
                ->where('fecha', $request->fecha)
                ->where('estado', '!=', 'cancelada')
                ->first();

            if ($existingReservation) {
                return redirect()->back()->with('warning', 'Ya tienes una reserva para esta sesión en esta fecha.');
            }

            // Verificar capacidad
            $reservationsCount = Reservation::where('session_id', $classSession->id)
                ->where('fecha', $request->fecha)
                ->where('estado', '!=', 'cancelada')
                ->count();

            if ($reservationsCount >= $classSession->capacidad_max) {
                return redirect()->back()->with('error', 'Lo sentimos, esta sesión está completa.');
            }

            // Crear la reserva
            Reservation::create([
                'user_id' => $userId,
                'session_id' => $classSession->id,
                'fecha' => $request->fecha,
                'estado' => 'confirmada',
                'check_in_time' => null,
            ]);

            return redirect()->back()->with('success', 'Te has inscrito correctamente en la sesión.');
        } catch (QueryException $e) {
            Log::error('Error SQL al reservar: ' . $e->getMessage());
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode == 1062) { // Duplicate entry
                return redirect()->back()->with('warning', 'Ya estás inscrito en esta actividad.');
            }

            return redirect()->back()->with('error', 'Error en la base de datos al procesar tu reserva.');
        } catch (\Exception $e) {
            Log::error('Error al reservar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al procesar tu reserva.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }







    public function myReservations()
    {
        // Obtiene el usuario autenticado con sus actividades cargadas

        //ORIGINAL
        //$user = User::with(['activities.trainer'])->find(Auth::id());

        $user = User::with([
            'reservations' => function ($query) {
                $query->where('fecha', '>=', now()->format('Y-m-d'))
                    ->where('estado', 'confirmada')
                    ->orderBy('fecha');
            },
            'reservations.classSession.activity',
            'reservations.classSession.trainer'
        ])->find(Auth::id());

        if (!$user) {
            return redirect()->route('login');
        }

        // Meto en cada reserva los datos pivot
        $reservations = $user->reservations;

        return view('users.reservation', compact('reservations'));
    }



    public function cancelReservation($reservationId)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Encontrar la reserva
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$reservation) {
            return redirect()->route('user.reservations')
                ->with('error', 'La reserva no existe o no tienes permiso para cancelarla.');
        }

        // Encontrar la información de la actividad para mostrarla en el mensaje de éxito
        $activityName = $reservation->classSession->activity->nombre ?? 'la actividad';


        // // Eliminar la reserva
        // DB::table('activity_user')
        //     ->where('id', $reservationId)
        //     ->delete();

        // Actualizar estado en lugar de eliminar
        $reservation->update(['estado' => 'cancelada']);

        return redirect()->route('user.reservations')
            ->with('success', "Reserva para {$activityName} cancelada correctamente.");
    }



    public function adminReservations()
    {
        // Obtener todas las reservas con sus relaciones
        $reservations = Reservation::with([
            'user',
            'classSession.activity',
            'classSession.trainer'
        ])->orderBy('fecha')->get();

        return view('users.adminReservation', compact('reservations'));
    }


    public function adminCancelReservation($reservationId)
    {
        // Encontrar la reserva
        $reservation = Reservation::with(['user', 'classSession.activity'])->find($reservationId);

        if (!$reservation) {
            return redirect()->route('user.admin.reservations')
                ->with('error', 'La reserva no existe.');
        }

        $activityName = $reservation->classSession->activity->nombre ?? 'la actividad';
        $userName = $reservation->user->nombre ?? 'el usuario';

        // Actualizar estado en lugar de eliminar
        $reservation->update(['estado' => 'cancelada']);

        return redirect()->route('user.admin.reservations')
            ->with('success', "Reserva de {$activityName} para {$userName} cancelada correctamente.");
    }
}
