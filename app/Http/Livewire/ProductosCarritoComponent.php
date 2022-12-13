<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Producto;

class ProductosCarritoComponent extends Component
{
    public $productos = array(), $total = 0, $tipo;

    public function mount($productos = [], $total = 0, $tipo = 'compra')
    {
        $this->productos = $productos;
        $this->total = $total;
        $this->tipo = $tipo;
    }

    public function render()
    {
        return view('livewire.productos-carrito-component');
    }

    protected $listeners = ['AgregarProductoCarrito'];

    public function AgregarProductoCarrito(Producto $producto){

        if(!isset($this->productos[$producto->id])){
            $cantidad = 0;
            $this->productos[$producto->id] = array(
                'id'=> $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'stock' => $producto->stock,
                'cantidad' => $cantidad,
                'medida' => $producto->medida,
                'precio' => $producto->precio_unitario,
                'subtotal' => $cantidad * $producto->precio_unitario
            );
        }else{
            $this->productos[$producto->id]['cantidad']++;
            $this->productos[$producto->id]['subtotal'] = $this->productos[$producto->id]['cantidad'] * $this->productos[$producto->id]['precio'];
        }
        $this->total = $this->obtenerTotal();
    }

    function obtenerTotal(){
        return array_sum(array_column($this->productos, 'subtotal'));
    }

    public function aumentarCantidadManual($indice, $cantidad){
        if($cantidad == 0){
            $this->emit('existe', 'No puedes vender el producto con cantidad cero');
            return;
        }
        if($this->tipo === 'VENTA' && $cantidad > $this->productos[$indice]['stock']){
            $this->emit('existe', 'No puedes vender mas que el stock actual');
            return;
        }
        $this->productos[$indice]['subtotal'] = $cantidad * $this->productos[$indice]['precio'];
        $this->total = $this->obtenerTotal();
    }

    public function quitarProducto($id){
        unset($this->productos[$id]);
    }
}
