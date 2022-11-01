<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ReporteComprasVentasComponent extends Component
{
    public $fecha_ini, $fecha_fin, $datos, $sin_resultado, $tipo;

    public function mount($tipo = '')
    {
        $this->fecha_ini = '';
        $this->fecha_fin = '';
        $this->tipo = $tipo;
        $this->sin_resultado = false;

        $tabla = $tipo === 'VENTA' ? 'detalle_ventas' : 'detalle_compras';
        $precio = $tipo === 'VENTA' ? 'precio_venta' : 'precio_compra';

        $this->datos = DB::table("$tabla")
            ->join('productos', 'productos.id', '=', "$tabla.producto_id")
            ->selectRaw("productos.nombre, SUM($tabla.cantidad) cantidad, productos.$precio precio, SUM($tabla.cantidad * productos.$precio) total")
            ->groupByRaw("productos.id, productos.nombre, productos.$precio")
            ->get();
    }

    public function render()
    {
        return view('livewire.reporte-compras-ventas-component');
    }

    public function listarVentasPorFecha(){
        if($this->fecha_ini == "" && $this->fecha_fin == "") return;

        $tabla = $this->tipo === 'VENTA' ? 'detalle_ventas' : 'detalle_compras';
        $precio = $this->tipo === 'VENTA' ? 'precio_venta' : 'precio_compra';

        $this->datos = DB::table("$tabla")
            ->join('productos', 'productos.id', '=', "$tabla.producto_id")
            ->join('ventas', 'ventas.id', '=', "$tabla.venta_id")
            ->selectRaw("productos.nombre, SUM($tabla.cantidad) cantidad, productos.$precio precio, SUM($tabla.cantidad * productos.$precio) total")
            ->groupByRaw("productos.id, productos.nombre, productos.$precio")
            ->whereBetween('ventas.fecha', [$this->fecha_ini, $this->fecha_fin])
            ->get();
        if(empty($this->ventas)) return $this->sin_resultado = true;
    }
}
