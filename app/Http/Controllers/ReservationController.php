<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;




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
                'activity_id' => 'required|exists:activities,id',
            ]);

            // Obtenemos el ID del usuario autenticado
            $userId = Auth::id();

            // Cargamos explícitamente el modelo User completo
            $user = User::find($userId);

            if (!$user) {
                return redirect()->back()->with('error', 'Usuario no encontrado.');
            }

            $activity = Activity::findOrFail($request->activity_id);

            // Verificar si ya está inscrito
            if (DB::table('activity_user')
                ->where('user_id', $userId)
                ->where('activity_id', $activity->id)
                ->exists()
            ) {
                return redirect()->back()->with('warning', 'Ya estás inscrito en esta actividad.');
            }

            // Verificar si hay plazas disponibles
            $actuales = DB::table('activity_user')
                ->where('activity_id', $activity->id)
                ->count();

            if ($actuales >= $activity->max_capacity) {
                return redirect()->back()->with('error', 'Lo sentimos, esta actividad está completa.');
            }

            // Usar DB directamente para crear la reserva
            DB::table('activity_user')->insert([
                'user_id' => $userId,
                'activity_id' => $activity->id,
                'reservation_date' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->back()->with('success', 'Te has inscrito correctamente en la actividad.');
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
}
