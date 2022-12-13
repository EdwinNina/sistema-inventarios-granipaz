<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use Livewire\Component;
use App\Models\Producto;
use Livewire\WithPagination;
use App\Models\DetalleCompra;
use Illuminate\Support\Facades\DB;

class ListadoComprasComponent extends Component
{
    use WithPagination;

    public $productos = [], $modalToggle = false;

    public function render()
    {
        $compras = DB::table('compras')
            ->join('personas', 'personas.id', '=', 'compras.proveedor_id')
            ->select('personas.empresa', 'compras.cantidad', 'compras.total', 'compras.fecha','compras.id', 'compras.codigo', 'compras.estado')
            ->paginate();

        return view('livewire.listado-compras-component', compact('compras'));
    }

    public function mostrarProductos($compra_id)
    {
        $this->productos = DB::table('detalle_compras')
            ->join('productos', 'productos.id', '=', 'detalle_compras.producto_id')
            ->where('detalle_compras.compra_id', '=', $compra_id)
            ->select('productos.nombre', 'productos.precio_unitario', 'productos.descripcion' ,'detalle_compras.cantidad', 'detalle_compras.subtotal')
            ->get();

        $this->modalToggle = true;
    }

    public function cambiarEstadoCompra(Compra $compra, $tipo)
    {
        $detalle_compra = DetalleCompra::where('compra_id', $compra->id)->get();

        foreach ($detalle_compra as $detalle) {
            $producto = Producto::find($detalle['producto_id']);
            $producto->stock = ($tipo === "habilitarCompra") ? $producto->stock + $detalle['cantidad'] : $producto->stock - $detalle['cantidad'];
            $producto->save();
        }
        $compra->estado = !$compra->estado;
        $compra->save();

        $this->emit('successMessage', ($tipo === "habilitarCompra") ? 'habilitarCompra' : 'anulacionCompra');
    }

    public function cerrarModal(){
        $this->modalToggle = false;
        $this->productos = [];
    }
}
