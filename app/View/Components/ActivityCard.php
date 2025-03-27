<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActivityCard extends Component
{
    public $activity;
    public $showReservationButton;

    /**
     * Create a new component instance.
     */
    public function __construct($activity, $showReservationButton = true)
    {
        $this->activity = $activity;
        $this->showReservationButton = $showReservationButton;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.activity-card');
    }
}
