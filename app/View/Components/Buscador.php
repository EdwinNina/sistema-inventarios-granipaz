<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Buscador extends Component
{
    public $criterio;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($criterio)
    {
        $this->criterio = $criterio;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.buscador');
    }
}
