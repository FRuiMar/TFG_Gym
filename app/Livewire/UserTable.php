<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;

class UserTable extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $filterRole = '';
    public $routePdf = true;

    // Propiedades para el modal de confirmación
    public $showDeleteModal = false;
    public $userIdToDelete = null;
    public $userToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'filterRole' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        // Inicialización al cargar el componente
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        // Aseguramos que el modal esté cerrado al ordenar
        $this->showDeleteModal = false;
        $this->userIdToDelete = null;
        $this->userToDelete = null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSearch() {}

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function updatedFilterRole()
    {
        // Este método se dispara cuando cambia el filtro de rol
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        // Este método se dispara cuando cambia el número por página
        $this->resetPage();
    }

    // Método para mostrar el modal de confirmación
    public function confirmUserDeletion($userId)
    {
        $this->userIdToDelete = $userId;
        $this->userToDelete = User::find($userId);
        $this->showDeleteModal = true;
    }

    // Método para cerrar el modal sin eliminar
    public function cancelUserDeletion()
    {
        $this->reset(['showDeleteModal', 'userIdToDelete', 'userToDelete']);
    }

    // Método para confirmar la eliminación
    public function deleteConfirmed()
    {
        // Guarda el ID antes de resetear el estado
        $userId = $this->userIdToDelete;

        // Limpia el estado del modal primero
        $this->reset(['showDeleteModal', 'userIdToDelete', 'userToDelete']);

        try {
            $user = User::find($userId);

            if (!$user) {
                return redirect()->route('users.index')->with('error', 'El usuario no existe.');
            }

            // Verificar si el usuario es un administrador y hay otros administradores
            if ($user->role === 'admin') {
                $adminCount = User::where('role', 'admin')->count();
                if ($adminCount <= 1) {
                    return redirect()->route('users.index')->with('error', 'No puedes eliminar el único administrador del sistema.');
                }
            }

            // Contar las actividades asociadas (reservas)
            $activityCount = $user->activities()->count();

            // Eliminar todas las reservas del usuario
            if ($activityCount > 0) {
                $user->activities()->detach();
            }

            // Eliminar la imagen del usuario si existe
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // Eliminar al usuario
            $user->delete();

            $message = 'Usuario eliminado con éxito.';
            if ($activityCount > 0) {
                $message .= " Se han cancelado {$activityCount} reservas asociadas.";
            }

            return redirect()->route('users.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al eliminar usuario: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Ha ocurrido un error al eliminar el usuario.');
        }
    }

    public function render()
    {
        $users = User::with('membership')
            ->where('role', '!=', 'TRAINER') // Excluyo a los entrenadores que los voy a poner en una vista a parte
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('dni', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function ($query) {
                $query->where('role', $this->filterRole);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.user-table', [
            'users' => $users
        ]);
    }

    // Método para eliminar un usuario
    public function deleteUser($userId)
    {
        $user = User::find($userId);

        if ($user) {
            // Verificar si el usuario tiene relaciones importantes
            if ($user->activities()->count() > 0) {
                session()->flash('error', 'No se puede eliminar el usuario porque tiene actividades asociadas.');
                return;
            }

            // Eliminar la imagen si existe
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $user->delete();

            session()->flash('success', 'Usuario eliminado con éxito.');
        }
    }



    public function updatedSortField()
    {
        // Cerramos el modal si cambia la ordenación
        if ($this->showDeleteModal) {
            $this->reset(['showDeleteModal', 'userIdToDelete', 'userToDelete']);
        }
    }

    public function updatedSortDirection()
    {
        // Cerramos el modal si cambia la dirección de ordenación
        if ($this->showDeleteModal) {
            $this->reset(['showDeleteModal', 'userIdToDelete', 'userToDelete']);
        }
    }

    public function updatingPage()
    {
        // Cerramos el modal al cambiar de página
        if ($this->showDeleteModal) {
            $this->reset(['showDeleteModal', 'userIdToDelete', 'userToDelete']);
        }
    }
}
