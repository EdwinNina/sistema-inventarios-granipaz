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

        if($tipo === 'VENTA'){
            $query = DB::table("detalle_ventas")
                ->join('productos', 'productos.id', '=', "detalle_ventas.producto_id")
                ->join('ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
               ->selectRaw("ventas.fecha, productos.nombre, SUM(detalle_ventas.cantidad) cantidad, productos.precio_unitario precio, SUM(detalle_ventas.cantidad * productos.precio_unitario) total, productos.descripcion, detalle_ventas.medida")
               ->groupByRaw("ventas.fecha, productos.id, productos.nombre, productos.precio_unitario, productos.descripcion, detalle_ventas.medida");
        }else{
            $query = DB::table("detalle_compras")
                ->join('productos', 'productos.id', '=', "detalle_compras.producto_id")
                ->join('compras', 'compras.id', '=', 'detalle_compras.compra_id')
               ->selectRaw("compras.fecha, productos.nombre, SUM(detalle_compras.cantidad) cantidad, productos.precio_unitario precio, SUM(detalle_compras.cantidad * productos.precio_unitario) total, productos.descripcion")
               ->groupByRaw("compras.fecha, productos.id, productos.nombre, productos.precio_unitario, productos.descripcion");
        }
        $this->datos = $query->get();
    }

    public function render()
    {
        return view('livewire.reporte-compras-ventas-component');
    }

    public function listarVentasPorFecha(){
        if($this->fecha_ini == "" && $this->fecha_fin == "") return;

        if($this->tipo === 'VENTA'){
            $query = DB::table("detalle_ventas")
                ->join('productos', 'productos.id', '=', "detalle_ventas.producto_id")
                ->join('ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
               ->selectRaw("ventas.fecha, productos.nombre, SUM(detalle_ventas.cantidad) cantidad, productos.precio_unitario precio, SUM(detalle_ventas.cantidad * productos.precio_unitario) total, productos.descripcion, detalle_ventas.medida")
               ->groupByRaw("ventas.fecha, productos.id, productos.nombre, productos.precio_unitario, productos.descripcion, detalle_ventas.medida")
               ->whereBetween('ventas.fecha', [$this->fecha_ini, $this->fecha_fin]);
        }else{
            $query = DB::table("detalle_compras")
                ->join('productos', 'productos.id', '=', "detalle_compras.producto_id")
                ->join('compras', 'compras.id', '=', 'detalle_compras.compra_id')
               ->selectRaw("compras.fecha, productos.nombre, SUM(detalle_compras.cantidad) cantidad, productos.precio_unitario precio, SUM(detalle_compras.cantidad * productos.precio_unitario) total, productos.descripcion")
               ->groupByRaw("compras.fecha, productos.id, productos.nombre, productos.precio_unitario, productos.descripcion")
               ->whereBetween('compras.fecha', [$this->fecha_ini, $this->fecha_fin]);
        }

        $this->datos = $query->get();

        if(empty($this->ventas)) return $this->sin_resultado = true;
    }
}
