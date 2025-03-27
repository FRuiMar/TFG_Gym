<?php

namespace App\Livewire;

use App\Models\Trainer;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;

class TrainerTable extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Propiedades para filtrado, ordenación y paginación
    public $search = '';
    public $sortField = 'first_name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $filterSpecialty = '';

    // Propiedades para el modal de confirmación
    public $showDeleteModal = false;
    public $trainerIdToDelete = null;
    public $trainerToDelete = null;

    // Configure los parámetros para la URL
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'first_name'],
        'sortDirection' => ['except' => 'asc'],
        'filterSpecialty' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    // Resetea la página cuando cambian los filtros
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterSpecialty()
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
    public function confirmTrainerDeletion($trainerId)
    {
        $this->trainerIdToDelete = $trainerId;
        $this->trainerToDelete = Trainer::find($trainerId);
        $this->showDeleteModal = true;
    }

    // Método para cerrar el modal sin eliminar
    public function cancelTrainerDeletion()
    {
        $this->reset(['showDeleteModal', 'trainerIdToDelete', 'trainerToDelete']);
    }

    // Método para confirmar la eliminación
    public function deleteConfirmed()
    {
        // Guarda el ID antes de resetear el estado
        $trainerId = $this->trainerIdToDelete;

        // Limpia el estado del modal primero
        $this->reset(['showDeleteModal', 'trainerIdToDelete', 'trainerToDelete']);

        try {
            $trainer = Trainer::find($trainerId);

            if (!$trainer) {
                return redirect()->route('trainers.index')->with('error', 'El entrenador no existe.');
            }

            // Verificar si el entrenador tiene actividades asignadas
            $activitiesCount = $trainer->activities()->count();

            if ($activitiesCount > 0) {
                // Buscar otro entrenador disponible (idealmente con la misma especialidad)
                $replacementTrainer = Trainer::where('id', '!=', $trainerId)
                    ->where('specialty', $trainer->specialty)
                    ->first();

                // Si no hay entrenador con la misma especialidad, buscar cualquier otro
                if (!$replacementTrainer) {
                    $replacementTrainer = Trainer::where('id', '!=', $trainerId)->first();
                }

                // Si no hay ningún otro entrenador, no permitir la eliminación
                if (!$replacementTrainer) {
                    return redirect()->route('trainers.index')->with('error', 'No se puede eliminar el único entrenador disponible. Necesitas al menos otro entrenador para reasignar las actividades.');
                }

                // Reasignar todas las actividades al nuevo entrenador
                $trainer->activities()->update(['trainer_id' => $replacementTrainer->id]);

                $message = "Entrenador eliminado con éxito. Se han reasignado {$activitiesCount} actividades al entrenador {$replacementTrainer->first_name} {$replacementTrainer->last_name}.";
            } else {
                $message = 'Entrenador eliminado con éxito.';
            }

            // Eliminar la imagen si existe
            if ($trainer->image && Storage::disk('public')->exists($trainer->image)) {
                Storage::disk('public')->delete($trainer->image);
            }

            // Eliminar el entrenador
            $trainer->delete();

            return redirect()->route('trainers.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al eliminar entrenador: ' . $e->getMessage());
            return redirect()->route('trainers.index')->with('error', 'Ha ocurrido un error al eliminar el entrenador.');
        }
    }
    // Función para eliminar entrenador
    public function deleteTrainer($trainerId)
    {
        $trainer = Trainer::find($trainerId);

        if ($trainer) {
            // Verificar si el entrenador tiene actividades asignadas
            if ($trainer->activities()->count() > 0) {
                session()->flash('error', 'No se puede eliminar el entrenador porque tiene actividades asociadas.');
                return;
            }

            // Eliminar la imagen si existe
            if ($trainer->image && Storage::disk('public')->exists($trainer->image)) {
                Storage::disk('public')->delete($trainer->image);
            }

            $trainer->delete();

            session()->flash('success', 'Entrenador eliminado con éxito.');
        }
    }

    // Método principal para renderizar el componente
    public function render()
    {
        // Obtener las especialidades únicas para el filtro
        $specialties = Trainer::select('specialty')->distinct()->pluck('specialty');

        // Consulta con filtros y ordenamiento
        $trainers = Trainer::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('dni', 'like', '%' . $this->search . '%')
                    ->orWhere('specialty', 'like', '%' . $this->search . '%');
            });
        })
            ->when($this->filterSpecialty, function ($query) {
                $query->where('specialty', $this->filterSpecialty);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.trainer-table', [
            'trainers' => $trainers,
            'specialties' => $specialties
        ]);
    }
}
