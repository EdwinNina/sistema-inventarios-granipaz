<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $modalToggle;
    public $modalToggle2;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalToggle, $modalToggle2 = false)
    {
        $this->modalToggle = $modalToggle;
        $this->modalToggle2 = $modalToggle2;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
