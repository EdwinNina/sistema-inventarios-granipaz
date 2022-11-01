<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Livewire\Component;
use App\Models\Producto;
use Livewire\WithPagination;

class ListadoProductosComponent extends Component
{
    use WithPagination;

    public $buscar = '', $tipo, $stock_minimo, $modalToggle = false;

    public function mount($tipo) {
        $this->tipo = $tipo;
        $empresa = Empresa::first();
        $this->stock_minimo = ($empresa) ? $empresa->stock_minimo : 10;
    }

    public function updatingBuscar() {
        $this->resetPage();
    }

    public function render()
    {
        $productos = Producto::query()
            ->when($this->buscar, function ($query){
                $query->where('nombre', 'like', '%'. $this->buscar.'%');
            })->with('subcategoria')->where('estado', 1)->orderBy('nombre')->paginate(10);

        return view('livewire.listado-productos-component', compact('productos'));
    }

    public function agregarProductoModal(){
        $this->modalToggle = true;
    }

    public function cerrarModal(){
        $this->modalToggle = false;
    }

    public function productoCarrito(Producto $producto){
        if($producto->stock < 1 && $this->tipo === 'venta') return $this->emit('existe', 'No puedes vender este producto porque su stock esta en cero');

        $this->emit('AgregarProductoCarrito', $producto->id);
    }
}
