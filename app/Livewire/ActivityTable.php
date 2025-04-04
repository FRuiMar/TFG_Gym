<?php

namespace App\Livewire;

use App\Models\Activity;
use App\Models\User;  // Cambiar Trainer por User
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;

class ActivityTable extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Propiedades para filtrado, ordenación y paginación
    public $search = '';
    public $sortField = 'nombre'; // Cambiado de 'name' a 'nombre' para coincidir con la BD
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $filterTrainer = '';

    // Propiedades para el modal de confirmación
    public $showDeleteModal = false;
    public $activityIdToDelete = null;
    public $activityToDelete = null;

    // Configure los parámetros para la URL
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'nombre'],  // Actualizado
        'sortDirection' => ['except' => 'asc'],
        'filterTrainer' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    // Resetea la página cuando cambian los filtros
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterTrainer()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    // Método para ordenar por campo
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Método para mostrar el modal de confirmación
    public function confirmActivityDeletion($activityId)
    {
        $this->activityIdToDelete = $activityId;
        $this->activityToDelete = Activity::find($activityId);
        $this->showDeleteModal = true;
    }

    // Método para cerrar el modal sin eliminar
    public function cancelActivityDeletion()
    {
        $this->reset(['showDeleteModal', 'activityIdToDelete', 'activityToDelete']);
    }

    // Método para confirmar la eliminación
    public function deleteConfirmed()
    {
        // Guarda el ID antes de resetear el modal
        $activityId = $this->activityIdToDelete;

        // Limpia el estado del modal primero
        $this->reset(['showDeleteModal', 'activityIdToDelete', 'activityToDelete']);

        try {
            $activity = Activity::find($activityId);

            if (!$activity) {
                return redirect()->route('activities.index')->with('error', 'La actividad no existe.');
            }

            // Verificar si hay entrenadores que tengan esta actividad como especialidad
            $trainersCount = User::where('role', 'TRAINER')
                ->where(function ($query) use ($activityId) {
                    $query->where('specialty_1_id', $activityId)
                        ->orWhere('specialty_2_id', $activityId);
                })->count();

            if ($trainersCount > 0) {
                return redirect()->route('activities.index')->with('error', 'No se puede eliminar esta actividad porque hay entrenadores que la tienen como especialidad.');
            }

            // Contar cuántos usuarios están inscritos a sesiones de esta actividad
            $sessionsWithUsers = $activity->classSessions()->withCount('users')->get();
            $userCount = $sessionsWithUsers->sum('users_count');

            if ($userCount > 0) {
                // Eliminar todas las reservas (registros pivot) para sesiones de esta actividad
                foreach ($activity->classSessions as $session) {
                    $session->users()->detach();
                }
                $message = "Actividad eliminada con éxito. Se han cancelado $userCount reservas asociadas.";
            } else {
                $message = 'Actividad eliminada con éxito.';
            }

            // Eliminar las sesiones de clase asociadas
            $activity->classSessions()->delete();

            // Eliminar la imagen si existe
            if ($activity->imagen && Storage::disk('public')->exists($activity->imagen)) {
                Storage::disk('public')->delete($activity->imagen);
            }

            // Eliminar la actividad
            $activity->delete();

            return redirect()->route('activities.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al eliminar actividad: ' . $e->getMessage());
            return redirect()->route('activities.index')->with('error', 'Ha ocurrido un error al eliminar la actividad: ' . $e->getMessage());
        }
    }

    // Método principal para renderizar el componente
    public function render()
    {
        // Obtener todos los entrenadores para el filtro
        $trainers = User::where('role', 'TRAINER')
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        // Consulta con filtros y ordenamiento
        $activities = Activity::with(['classSessions.trainer'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                        ->orWhere('nivel_dificultad', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterTrainer, function ($query) {
                $query->whereHas('classSessions', function ($q) {
                    $q->where('trainer_id', $this->filterTrainer);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.activity-table', [
            'activities' => $activities,
            'trainers' => $trainers
        ]);
    }
}
