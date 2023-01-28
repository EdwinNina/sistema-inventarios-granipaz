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
               ->selectRaw("ventas.fecha, productos.nombre, SUM(detalle_ventas.cantidad) cantidad, detalle_ventas.precio_venta precio, SUM(detalle_ventas.cantidad * detalle_ventas.precio_venta) total, productos.descripcion, detalle_ventas.medida")
               ->groupByRaw("ventas.fecha, productos.id, productos.nombre, detalle_ventas.precio_venta, productos.descripcion, detalle_ventas.medida");
        }else{
            $query = DB::table("detalle_compras")
                ->join('productos', 'productos.id', '=', "detalle_compras.producto_id")
                ->join('compras', 'compras.id', '=', 'detalle_compras.compra_id')
               ->selectRaw("compras.fecha, productos.nombre, SUM(detalle_compras.cantidad) cantidad, detalle_compras.precio_compra precio, SUM(detalle_compras.cantidad * detalle_compras.precio_compra) total, productos.descripcion")
               ->groupByRaw("compras.fecha, productos.id, productos.nombre, detalle_compras.precio_compra, productos.descripcion");
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
               ->selectRaw("ventas.fecha, productos.nombre, SUM(detalle_ventas.cantidad) cantidad, detalle_ventas.precio_venta precio, SUM(detalle_ventas.cantidad * detalle_ventas.precio_venta) total, productos.descripcion, detalle_ventas.medida")
               ->groupByRaw("ventas.fecha, productos.id, productos.nombre, detalle_ventas.precio_venta, productos.descripcion, detalle_ventas.medida")
               ->whereBetween('ventas.fecha', [$this->fecha_ini, $this->fecha_fin]);
        }else{
            $query = DB::table("detalle_compras")
                ->join('productos', 'productos.id', '=', "detalle_compras.producto_id")
                ->join('compras', 'compras.id', '=', 'detalle_compras.compra_id')
               ->selectRaw("compras.fecha, productos.nombre, SUM(detalle_compras.cantidad) cantidad, detalle_compras.precio_compra precio, SUM(detalle_compras.cantidad * detalle_compras.precio_compra) total, productos.descripcion")
               ->groupByRaw("compras.fecha, productos.id, productos.nombre, detalle_compras.precio_compra, productos.descripcion")
               ->whereBetween('compras.fecha', [$this->fecha_ini, $this->fecha_fin]);
        }

        $this->datos = $query->get();

        if(empty($this->ventas)) return $this->sin_resultado = true;
    }
}
