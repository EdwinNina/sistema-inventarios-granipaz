<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SubCategoriaComponent extends Component
{
    public $a_subcategorias = [];

    public function mount($a_subcategorias = []){
        $this->a_subcategorias = $a_subcategorias;
    }

    public function render()
    {
        return view('livewire.sub-categoria-component');
    }

    public function agregarSubcategoria(){
        $this->a_subcategorias[] = [
            'nombre' => '',
            'descripcion' => '',
        ];
    }

    public function eliminarSubcategoria($index){
        unset($this->a_subcategorias[$index]);
        $this->a_subcategorias = array_values($this->a_subcategorias);
    }
}
