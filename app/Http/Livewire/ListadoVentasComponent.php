<?php

namespace App\Http\Livewire;

use App\Models\Venta;
use Livewire\Component;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ListadoVentasComponent extends Component
{
    use WithPagination;

    public $productos = [], $modalToggle = false;

    public function render()
    {
        $ventas = DB::table('ventas')
            ->join('personas', 'personas.id', '=', 'ventas.cliente_id')
            ->select('personas.empresa', 'ventas.cantidad', 'ventas.total', 'ventas.fecha','ventas.id', 'ventas.codigo', 'ventas.estado', 'ventas.tipo_comprobante', 'ventas.nro_comprobante')
            ->paginate();

        return view('livewire.listado-ventas-component', compact('ventas'));
    }

    public function mostrarProductos($venta_id)
    {
        $this->productos = DB::table('detalle_ventas')
            ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->where('detalle_ventas.venta_id', '=', $venta_id)
            ->select('productos.nombre', 'productos.precio_unitario', 'detalle_ventas.cantidad', 'detalle_ventas.subtotal')
            ->get();

        $this->modalToggle = true;
    }

    public function cambiarEstadoVenta(Venta $venta, $tipo)
    {
        $detalle_venta = DetalleVenta::where('venta_id', $venta->id)->get();

        foreach ($detalle_venta as $detalle) {
            $producto = Producto::find($detalle['producto_id']);
            $producto->stock = ($tipo === "habilitarVenta") ? $producto->stock - $detalle['cantidad'] : $producto->stock + $detalle['cantidad'];
            $producto->save();
        }
        $venta->estado = !$venta->estado;
        $venta->save();

        $this->emit('successMessage', ($tipo === "habilitarVenta") ? 'habilitarVenta' : 'anulacionVenta');
    }

    public function cerrarModal(){
        $this->modalToggle = false;
        $this->productos = [];
    }
}
