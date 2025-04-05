<?php

namespace App\Http\Controllers;

use App\Models\ClassSession;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassSessionController extends Controller
{
    public function create(Request $request)
    {
        $activity = Activity::findOrFail($request->input('activity_id'));
        $trainers = User::where('role', 'TRAINER')->orderBy('surname')->get();

        // Lista de días de la semana en español
        $diasSemana = [
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes',
            'Sábado',
            'Domingo'
        ];

        return view('class-sessions.create', compact('activity', 'trainers', 'diasSemana'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'trainer_id' => 'required|exists:users,id',
            'dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'capacidad_max' => 'required|integer|min:1',
            'sala' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Verificar disponibilidad del entrenador
        $conflicto = $this->verificarDisponibilidadEntrenador(
            $validated['trainer_id'],
            $validated['dia_semana'],
            $validated['hora_inicio'],
            $validated['hora_fin'],
            null
        );

        if ($conflicto) {
            return redirect()->back()->withInput()->with(
                'error',
                'El entrenador ya tiene una sesión en ese horario: ' .
                    $conflicto->activity->nombre . ' (' .
                    $conflicto->dia_semana . ' ' .
                    substr($conflicto->hora_inicio, 0, 5) . '-' .
                    substr($conflicto->hora_fin, 0, 5) . ')'
            );
        }

        // Verificar disponibilidad de la sala
        $conflictoSala = $this->verificarDisponibilidadSala(
            $validated['sala'],
            $validated['dia_semana'],
            $validated['hora_inicio'],
            $validated['hora_fin'],
            null
        );

        if ($conflictoSala) {
            return redirect()->back()->withInput()->with(
                'error',
                'La sala ya está ocupada en ese horario: ' .
                    $conflictoSala->activity->nombre . ' (' .
                    $conflictoSala->dia_semana . ' ' .
                    substr($conflictoSala->hora_inicio, 0, 5) . '-' .
                    substr($conflictoSala->hora_fin, 0, 5) . ')'
            );
        }

        // Establecer is_active a true por defecto si no se proporciona
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        $session = ClassSession::create($validated);

        return redirect()->route('activities.index')
            ->with('success', 'Sesión creada correctamente');
    }

    public function edit(ClassSession $classSession)
    {
        $activity = $classSession->activity;
        $trainers = User::where('role', 'TRAINER')->orderBy('surname')->get();

        // Lista de días de la semana en español
        $diasSemana = [
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes',
            'Sábado',
            'Domingo'
        ];

        return view('class-sessions.edit', compact('classSession', 'activity', 'trainers', 'diasSemana'));
    }

    public function update(Request $request, ClassSession $classSession)
    {
        $validated = $request->validate([
            'trainer_id' => 'required|exists:users,id',
            'dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'capacidad_max' => 'required|integer|min:1',
            'sala' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Verificar disponibilidad del entrenador (excepto para esta misma sesión)
        $conflicto = $this->verificarDisponibilidadEntrenador(
            $validated['trainer_id'],
            $validated['dia_semana'],
            $validated['hora_inicio'],
            $validated['hora_fin'],
            $classSession->id
        );

        if ($conflicto) {
            return redirect()->back()->withInput()->with(
                'error',
                'El entrenador ya tiene una sesión en ese horario: ' .
                    $conflicto->activity->nombre . ' (' .
                    $conflicto->dia_semana . ' ' .
                    substr($conflicto->hora_inicio, 0, 5) . '-' .
                    substr($conflicto->hora_fin, 0, 5) . ')'
            );
        }

        // Verificar disponibilidad de la sala (excepto para esta misma sesión)
        $conflictoSala = $this->verificarDisponibilidadSala(
            $validated['sala'],
            $validated['dia_semana'],
            $validated['hora_inicio'],
            $validated['hora_fin'],
            $classSession->id
        );

        if ($conflictoSala) {
            return redirect()->back()->withInput()->with(
                'error',
                'La sala ya está ocupada en ese horario: ' .
                    $conflictoSala->activity->nombre . ' (' .
                    $conflictoSala->dia_semana . ' ' .
                    substr($conflictoSala->hora_inicio, 0, 5) . '-' .
                    substr($conflictoSala->hora_fin, 0, 5) . ')'
            );
        }

        // Si no se marca "is_active", establecerlo a false
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $classSession->update($validated);

        return redirect()->route('activities.index')
            ->with('success', 'Sesión actualizada correctamente');
    }

    public function destroy(ClassSession $classSession)
    {
        // Verificar si hay usuarios inscritos
        $usersCount = $classSession->users()->count();

        // Cancelar todas las inscripciones si existen
        if ($usersCount > 0) {
            $classSession->users()->detach();
            $message = "Sesión eliminada. Se han cancelado $usersCount reservas de usuarios.";
        } else {
            $message = "Sesión eliminada correctamente.";
        }

        $classSession->delete();

        return redirect()->route('activities.index')
            ->with('success', $message);
    }

    /**
     * Verifica si un entrenador ya tiene una sesión en el mismo horario
     */
    private function verificarDisponibilidadEntrenador($trainerId, $diaSemana, $horaInicio, $horaFin, $excluirSessionId = null)
    {
        $query = ClassSession::where('trainer_id', $trainerId)
            ->where('dia_semana', $diaSemana)
            ->where(function ($q) use ($horaInicio, $horaFin) {
                $q->where(function ($q2) use ($horaInicio, $horaFin) {
                    // El horario nuevo comienza durante una sesión existente
                    $q2->where('hora_inicio', '<=', $horaInicio)
                        ->where('hora_fin', '>', $horaInicio);
                })->orWhere(function ($q2) use ($horaInicio, $horaFin) {
                    // El horario nuevo termina durante una sesión existente
                    $q2->where('hora_inicio', '<', $horaFin)
                        ->where('hora_fin', '>=', $horaFin);
                })->orWhere(function ($q2) use ($horaInicio, $horaFin) {
                    // El horario nuevo contiene completamente una sesión existente
                    $q2->where('hora_inicio', '>=', $horaInicio)
                        ->where('hora_fin', '<=', $horaFin);
                });
            });

        // Excluir la sesión actual si estamos editando
        if ($excluirSessionId) {
            $query->where('id', '!=', $excluirSessionId);
        }

        return $query->with('activity')->first();
    }

    /**
     * Verifica si una sala ya está ocupada en el mismo horario
     */
    private function verificarDisponibilidadSala($sala, $diaSemana, $horaInicio, $horaFin, $excluirSessionId = null)
    {
        $query = ClassSession::where('sala', $sala)
            ->where('dia_semana', $diaSemana)
            ->where(function ($q) use ($horaInicio, $horaFin) {
                $q->where(function ($q2) use ($horaInicio, $horaFin) {
                    $q2->where('hora_inicio', '<=', $horaInicio)
                        ->where('hora_fin', '>', $horaInicio);
                })->orWhere(function ($q2) use ($horaInicio, $horaFin) {
                    $q2->where('hora_inicio', '<', $horaFin)
                        ->where('hora_fin', '>=', $horaFin);
                })->orWhere(function ($q2) use ($horaInicio, $horaFin) {
                    $q2->where('hora_inicio', '>=', $horaInicio)
                        ->where('hora_fin', '<=', $horaFin);
                });
            });

        // Excluir la sesión actual si estamos editando
        if ($excluirSessionId) {
            $query->where('id', '!=', $excluirSessionId);
        }

        return $query->with('activity')->first();
    }
}
