<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Activity;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;

class ReservationTable extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Propiedades para filtrado, ordenación y paginación
    public $search = '';
    public $sortField = 'reservation_date';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $filterUser = '';
    public $filterActivity = '';

    // Propiedades para el modal de confirmación
    public $showDeleteModal = false;
    public $reservationIdToDelete = null;
    public $reservationToDelete = null;

    // Configure los parámetros para la URL
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'reservation_date'],
        'sortDirection' => ['except' => 'desc'],
        'filterUser' => ['except' => ''],
        'filterActivity' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    // Resetea la página cuando cambian los filtros
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterUser()
    {
        $this->resetPage();
    }

    public function updatedFilterActivity()
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
    public function confirmReservationDeletion($reservationId)
    {
        $this->reservationIdToDelete = $reservationId;

        // Obtener la información de la reserva para mostrarla en el modal
        $this->reservationToDelete = DB::table('activity_user')
            ->join('users', 'activity_user.user_id', '=', 'users.id')
            ->join('activities', 'activity_user.activity_id', '=', 'activities.id')
            ->leftJoin('trainers', 'activities.trainer_id', '=', 'trainers.id')
            ->select(
                'activity_user.id as reservation_id',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'activities.id as activity_id',
                'activities.name as activity_name',
                'activities.schedule as schedule',
                'trainers.first_name as trainer_first_name',
                'trainers.last_name as trainer_last_name',
                'activity_user.reservation_date'
            )
            ->where('activity_user.id', $reservationId)
            ->first();

        $this->showDeleteModal = true;
    }

    // Método para cerrar el modal sin eliminar
    public function cancelReservationDeletion()
    {
        $this->reset(['showDeleteModal', 'reservationIdToDelete', 'reservationToDelete']);
    }

    // Método para confirmar la eliminación
    public function deleteConfirmed()
    {
        // Guarda el ID antes de resetear el modal
        $reservationId = $this->reservationIdToDelete;

        // Primero limpia el estado modal
        $this->reset(['showDeleteModal', 'reservationIdToDelete', 'reservationToDelete']);

        try {
            // Encontrar la reserva
            $reservation = DB::table('activity_user')
                ->where('id', $reservationId)
                ->first();

            if (!$reservation) {
                return redirect()->route('user.admin.reservations')->with('error', 'La reserva no existe o no se puede cancelar.');
            }

            // Encontrar la información de la actividad para mostrarla en el mensaje de éxito
            $activity = Activity::find($reservation->activity_id);
            $user = User::find($reservation->user_id);

            $activityName = $activity ? $activity->name : 'la actividad';
            $userName = $user ? $user->name : 'el usuario';

            // Eliminar la reserva
            DB::table('activity_user')
                ->where('id', $reservationId)
                ->delete();

            return redirect()->route('user.admin.reservations')->with('success', "Reserva de {$activityName} para {$userName} cancelada correctamente.");
        } catch (\Exception $e) {
            Log::error('Error al cancelar reserva: ' . $e->getMessage());
            return redirect()->route('user.admin.reservations')->with('error', 'Ha ocurrido un error al cancelar la reserva.');
        }
    }

    // // Método para cancelar una reserva
    // public function cancelReservation($reservationId)
    // {
    //     // Encontrar la reserva
    //     $reservation = DB::table('activity_user')
    //         ->where('id', $reservationId)
    //         ->first();

    //     if (!$reservation) {
    //         session()->flash('error', 'La reserva no existe o no se puede cancelar.');
    //         return;
    //     }

    //     // Encontrar la información de la actividad para mostrarla en el mensaje de éxito
    //     $activity = Activity::find($reservation->activity_id);
    //     $user = User::find($reservation->user_id);

    //     $activityName = $activity ? $activity->name : 'la actividad';
    //     $userName = $user ? $user->name : 'el usuario';

    //     // Eliminar la reserva
    //     DB::table('activity_user')
    //         ->where('id', $reservationId)
    //         ->delete();

    //     session()->flash('success', "Reserva de {$activityName} para {$userName} cancelada correctamente.");
    // }

    // Método principal para renderizar el componente
    public function render()
    {
        // Obtener todos los usuarios y actividades para los filtros
        $users = User::all();
        $activities = Activity::all();

        // Consulta con filtros y ordenamiento
        $reservations = DB::table('activity_user')
            ->join('users', 'activity_user.user_id', '=', 'users.id')
            ->join('activities', 'activity_user.activity_id', '=', 'activities.id')
            ->leftJoin('trainers', 'activities.trainer_id', '=', 'trainers.id')
            ->select(
                'activity_user.id as reservation_id',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'activities.id as activity_id',
                'activities.name as activity_name',
                'activities.schedule as schedule',
                'trainers.first_name as trainer_first_name',
                'trainers.last_name as trainer_last_name',
                'activity_user.reservation_date'
            )
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('users.name', 'like', '%' . $this->search . '%')
                        ->orWhere('users.email', 'like', '%' . $this->search . '%')
                        ->orWhere('activities.name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterUser, function ($query) {
                $query->where('users.id', $this->filterUser);
            })
            ->when($this->filterActivity, function ($query) {
                $query->where('activities.id', $this->filterActivity);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.reservation-table', [
            'reservations' => $reservations,
            'users' => $users,
            'activities' => $activities
        ]);
    }
}
