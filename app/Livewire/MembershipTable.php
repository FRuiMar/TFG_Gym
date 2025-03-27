<?php

namespace App\Livewire;

use App\Models\Membership;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Livewire\WithoutUrlPagination;

class MembershipTable extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Propiedades para filtrado, ordenación y paginación
    public $search = '';
    public $sortField = 'type';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // Propiedades para el modal de confirmación
    public $showDeleteModal = false;
    public $membershipIdToDelete = null;
    public $membershipToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'type'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    // Resetea la página cuando cambia la búsqueda
    public function updatingSearch()
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
    public function confirmMembershipDeletion($membershipId)
    {
        $this->membershipIdToDelete = $membershipId;
        $this->membershipToDelete = Membership::withCount('users')->find($membershipId);
        $this->showDeleteModal = true;
    }

    // Método para cerrar el modal sin eliminar
    public function cancelMembershipDeletion()
    {
        $this->reset(['showDeleteModal', 'membershipIdToDelete', 'membershipToDelete']);
    }

    // Método para confirmar la eliminación
    public function deleteConfirmed()
    {

        // Guarda el ID antes de resetear el modal
        $membershipId = $this->membershipIdToDelete;

        // Primero limpia el estado modal
        $this->reset(['showDeleteModal', 'membershipIdToDelete', 'membershipToDelete']);

        try {
            $membership = Membership::find($membershipId);

            if (!$membership) {
                return redirect()->route('memberships.index')->with('error', 'La membresía no existe.');
            }

            // Verificar si es una membresía que no debe eliminarse
            if ($membership->type === 'Sin membresía') {
                return redirect()->route('memberships.index')->with('error', 'No puedes eliminar la membresía "Sin membresía" ya que es utilizada por defecto.');
            }

            // Contar usuarios asociados para el mensaje informativo
            $userCount = $membership->users()->count();

            // Eliminar la membresía
            $membership->delete();

            if ($userCount > 0) {
                $message = 'Membresía eliminada correctamente. Recuerde verificar los ' . $userCount . ' usuarios afectados.';
            } else {
                $message = 'Membresía eliminada correctamente.';
            }

            return redirect()->route('memberships.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al eliminar membresía: ' . $e->getMessage());
            return redirect()->route('memberships.index')->with('error', 'Ha ocurrido un error al eliminar la membresía.');
        }


        // $this->deleteMembership($this->membershipIdToDelete);
        // $this->reset(['showDeleteModal', 'membershipIdToDelete', 'membershipToDelete']);
    }

    // Función para eliminar membresía
    public function deleteMembership($membershipId)
    {
        try {
            $membership = Membership::find($membershipId);

            if (!$membership) {
                session()->flash('error', 'La membresía no existe.');
                return;
            }

            // Verificar si es una membresía que no debe eliminarse
            if ($membership->type === 'Sin membresía') {
                session()->flash('error', 'No puedes eliminar la membresía "Sin membresía" ya que es utilizada por defecto.');
                return;
            }

            // Buscar o crear membresía por defecto
            $defaultMembership = Membership::where('type', 'Sin membresía')->first();
            if (!$defaultMembership) {
                $defaultMembership = Membership::create([
                    'type' => 'Sin membresía',
                    'price' => 0,
                    'duration_months' => 0,
                ]);
            }

            // Verificar usuarios asociados
            $userCount = $membership->users()->count();
            if ($userCount > 0) {
                // Reasignar usuarios a la membresía por defecto
                $membership->users()->update(['membership_id' => $defaultMembership->id]);
                $message = 'Membresía eliminada correctamente. Se han reasignado ' . $userCount . ' usuarios a la membresía "Sin membresía".';
            } else {
                $message = 'Membresía eliminada correctamente.';
            }

            $membership->delete();
            session()->flash('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al eliminar membresía: ' . $e->getMessage());
            session()->flash('error', 'Ha ocurrido un error al eliminar la membresía.');
        }
    }

    public function render()
    {
        $memberships = Membership::withCount('users')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('type', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.membership-table', [
            'memberships' => $memberships
        ]);
    }
}
