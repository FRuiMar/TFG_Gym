<?php

namespace App\Livewire;

use App\Models\Activity;
use App\Models\Trainer;
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
    public $sortField = 'name';
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
        'sortField' => ['except' => 'name'],
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

            // Contar cuántos usuarios están inscritos en esta actividad
            $userCount = $activity->users()->count();

            if ($userCount > 0) {
                // Eliminar todas las reservas (registros pivot) para esta actividad
                $activity->users()->detach();
                $message = "Actividad eliminada con éxito. Se han cancelado $userCount reservas asociadas.";
            } else {
                $message = 'Actividad eliminada con éxito.';
            }

            // Eliminar la imagen si existe
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }

            // Eliminar la actividad
            $activity->delete();

            return redirect()->route('activities.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al eliminar actividad: ' . $e->getMessage());
            return redirect()->route('activities.index')->with('error', 'Ha ocurrido un error al eliminar la actividad.');
        }
    }

    // Función para eliminar actividad
    public function deleteActivity($activityId)
    {
        $activity = Activity::find($activityId);

        if ($activity) {
            // Verificar si la actividad tiene usuarios inscritos
            if ($activity->users()->count() > 0) {
                session()->flash('error', 'No se puede eliminar la actividad porque hay usuarios inscritos.');
                return;
            }

            // Eliminar la imagen si existe
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }

            $activity->delete();

            session()->flash('success', 'Actividad eliminada con éxito.');
        }
    }

    // Método principal para renderizar el componente
    public function render()
    {
        // Obtener todos los entrenadores para el filtro
        $trainers = Trainer::all();

        // Consulta con filtros y ordenamiento
        $activities = Activity::with('trainer')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('schedule', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterTrainer, function ($query) {
                $query->where('trainer_id', $this->filterTrainer);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.activity-table', [
            'activities' => $activities,
            'trainers' => $trainers
        ]);
    }
}
