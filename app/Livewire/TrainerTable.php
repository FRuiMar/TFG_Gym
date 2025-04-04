<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Activity;
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
    public $sortField = 'name';
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
        'sortField' => ['except' => 'name'],
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
        $this->trainerToDelete = User::find($trainerId);
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
            $trainer = User::find($trainerId);

            if (!$trainer || $trainer->role !== 'TRAINER') {
                return redirect()->route('trainers.index')->with('error', 'El entrenador no existe.');
            }

            // Verificar si el entrenador tiene clases asignadas
            $classesCount = $trainer->classSessions()->count();

            if ($classesCount > 0) {
                // Buscar otro entrenador disponible (idealmente con la misma especialidad)
                $replacementTrainer = User::where('id', '!=', $trainerId)
                    ->where('role', 'TRAINER')
                    ->where(function ($query) use ($trainer) {
                        $query->where('specialty_1_id', $trainer->specialty_1_id)
                            ->orWhere('specialty_2_id', $trainer->specialty_1_id)
                            ->orWhere('specialty_1_id', $trainer->specialty_2_id)
                            ->orWhere('specialty_2_id', $trainer->specialty_2_id);
                    })
                    ->first();

                // Si no hay entrenador con la misma especialidad, buscar cualquier otro
                if (!$replacementTrainer) {
                    $replacementTrainer = User::where('id', '!=', $trainerId)
                        ->where('role', 'TRAINER')
                        ->first();
                }

                // Si no hay ningún otro entrenador, no permitir la eliminación
                if (!$replacementTrainer) {
                    return redirect()->route('trainers.index')->with('error', 'No se puede eliminar el único entrenador disponible. Necesitas al menos otro entrenador para reasignar las clases.');
                }

                // Reasignar todas las clases al nuevo entrenador
                $trainer->classSessions()->update(['trainer_id' => $replacementTrainer->id]);

                $message = "Entrenador eliminado con éxito. Se han reasignado {$classesCount} clases al entrenador {$replacementTrainer->name} {$replacementTrainer->surname} {$replacementTrainer->surname2}.";
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
            return redirect()->route('trainers.index')->with('error', 'Ha ocurrido un error al eliminar el entrenador: ' . $e->getMessage());
        }
    }

    // Método principal para renderizar el componente
    public function render()
    {
        // Obtener las actividades para el filtro de especialidades
        $specialties = Activity::orderBy('nombre')->get();

        // Consulta base
        $query = User::with(['specialty1', 'specialty2'])
            ->where('role', 'TRAINER')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('surname', 'like', '%' . $this->search . '%')
                        ->orWhere('surname2', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('dni', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterSpecialty, function ($query) {
                $query->where(function ($q) {
                    $q->where('specialty_1_id', $this->filterSpecialty)
                        ->orWhere('specialty_2_id', $this->filterSpecialty);
                });
            });

        // Ordenación especial por apellidos (considera ambos)
        if ($this->sortField === 'surname') {
            $query->orderBy('surname', $this->sortDirection)
                ->orderBy('surname2', $this->sortDirection);
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $trainers = $query->paginate($this->perPage);

        return view('livewire.trainer-table', [
            'trainers' => $trainers,
            'specialties' => $specialties
        ]);
    }

    // Método para contar las clases de un entrenador
    public function getClassCount($trainerId)
    {
        return User::find($trainerId)->classSessions()->count();
    }
}
