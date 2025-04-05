<?php

namespace App\Livewire;

use App\Models\Activity;
use App\Models\ClassSession;
use App\Models\User;
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
    public $sortField = 'nombre';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $filterTrainer = '';

    // Para expandir filas
    public $expandedRows = [];

    // Propiedades para el modal de confirmación de actividad
    public $showDeleteModal = false;
    public $activityIdToDelete = null;
    public $activityToDelete = null;

    // Propiedades para el modal de confirmación de sesión
    public $showSessionDeleteModal = false;
    public $sessionIdToDelete = null;
    public $sessionToDelete = null;

    // Configure los parámetros para la URL
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'nombre'],
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

    // Método para expandir/colapsar filas
    public function toggleExpand($activityId)
    {
        if (isset($this->expandedRows[$activityId])) {
            $this->expandedRows[$activityId] = !$this->expandedRows[$activityId];
        } else {
            $this->expandedRows[$activityId] = true;
        }
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

    // Método para mostrar el modal de confirmación de actividad
    public function confirmActivityDeletion($activityId)
    {
        $this->activityIdToDelete = $activityId;
        $this->activityToDelete = Activity::find($activityId);
        $this->showDeleteModal = true;
    }

    // Método para cerrar el modal sin eliminar actividad
    public function cancelActivityDeletion()
    {
        $this->reset(['showDeleteModal', 'activityIdToDelete', 'activityToDelete']);
    }

    // Método para mostrar el modal de confirmación de sesión
    public function confirmSessionDeletion($sessionId)
    {
        $this->sessionIdToDelete = $sessionId;
        $this->sessionToDelete = ClassSession::find($sessionId);
        $this->showSessionDeleteModal = true;
    }

    // Método para cerrar el modal sin eliminar sesión
    public function cancelSessionDeletion()
    {
        $this->reset(['showSessionDeleteModal', 'sessionIdToDelete', 'sessionToDelete']);
    }

    // Método para eliminar una sesión
    public function deleteSession()
    {
        try {
            $session = ClassSession::find($this->sessionIdToDelete);

            if (!$session) {
                session()->flash('error', 'La sesión no existe.');
                $this->reset(['showSessionDeleteModal', 'sessionIdToDelete', 'sessionToDelete']);
                return;
            }

            // Verificar si hay usuarios inscritos
            $usersCount = $session->users()->count();

            if ($usersCount > 0) {
                // Eliminar inscripciones
                $session->users()->detach();
                $message = "Sesión eliminada. Se han cancelado $usersCount inscripciones.";
            } else {
                $message = "Sesión eliminada correctamente.";
            }

            $session->delete();
            session()->flash('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al eliminar sesión: ' . $e->getMessage());
            session()->flash('error', 'Ha ocurrido un error al eliminar la sesión.');
        }

        $this->reset(['showSessionDeleteModal', 'sessionIdToDelete', 'sessionToDelete']);
    }

    // Método para confirmar la eliminación de actividad
    public function deleteConfirmed()
    {
        // Guarda el ID antes de resetear el modal
        $activityId = $this->activityIdToDelete;

        // Limpia el estado del modal primero
        $this->reset(['showDeleteModal', 'activityIdToDelete', 'activityToDelete']);

        try {
            $activity = Activity::find($activityId);

            if (!$activity) {
                session()->flash('error', 'La actividad no existe.');
                return;
            }

            // Verificar si hay entrenadores que tengan esta actividad como especialidad
            $trainersCount = User::where('role', 'TRAINER')
                ->where(function ($query) use ($activityId) {
                    $query->where('specialty_1_id', $activityId)
                        ->orWhere('specialty_2_id', $activityId);
                })->count();

            if ($trainersCount > 0) {
                session()->flash('error', 'No se puede eliminar esta actividad porque hay entrenadores que la tienen como especialidad.');
                return;
            }

            // Contar sesiones y usuarios inscritos
            $sessionsCount = $activity->classSessions()->count();
            $usersInSessions = 0;

            foreach ($activity->classSessions as $session) {
                $usersInSessions += $session->users()->count();
                // Eliminar relaciones de usuarios con sesiones
                $session->users()->detach();
            }

            // Eliminar las sesiones de clase asociadas
            $activity->classSessions()->delete();

            // Eliminar la imagen si existe
            if ($activity->imagen && Storage::disk('public')->exists($activity->imagen)) {
                Storage::disk('public')->delete($activity->imagen);
            }

            // Eliminar la actividad
            $activity->delete();

            $message = "Actividad eliminada con éxito.";
            if ($sessionsCount > 0) {
                $message .= " Se han eliminado $sessionsCount sesiones";
                if ($usersInSessions > 0) {
                    $message .= " y $usersInSessions reservas de usuarios.";
                } else {
                    $message .= ".";
                }
            }

            session()->flash('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al eliminar actividad: ' . $e->getMessage());
            session()->flash('error', 'Ha ocurrido un error al eliminar la actividad: ' . $e->getMessage());
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
