<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Livewire\Component;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class KardexProductosComponent extends Component
{
    public $nombre, $productos, $categorias, $detalle_kardex, $stock_minimo, $filtrarCategoria = '', $producto_seleccionado;
    public $fecha_ini, $fecha_fin;

    public function mount()
    {
        $empresa = Empresa::first();
        $this->categorias = Categoria::where('estado', 1)->select('id','nombre')->get();
        $this->resetBusqueda();
        $this->stock_minimo = $empresa->stock_minimo;
    }

    public function render()
    {
        return view('livewire.kardex-productos-component');
    }

    public function resetBusqueda(){
        $this->nombre = '';
        $this->filtrarCategoria = '';
        $this->producto_seleccionado = [];
        $this->productos = [];
        $this->detalle_kardex = [];
        $this->fecha_ini = '';
        $this->fecha_fin = '';
    }

    public function updatedFiltrarCategoria(){
        $this->producto_seleccionado = [];
        $this->productos = [];
        $this->detalle_kardex = [];
    }

    public function updatedNombre()
    {
        $this->detalle_kardex = [];
        $this->producto_seleccionado = [];

        $data = Producto::query()
            ->when($this->nombre, function($query){
                $query->where('nombre', 'like', '%' . $this->nombre . '%');
            })
            ->when(!empty($this->filtrarCategoria), function($query){
                $query->where('categoria_id', $this->filtrarCategoria);
            })
            ->with('categoria')
            ->where('estado', 1)
            ->get()
            ->toArray();
        $a_productos_formato = [];
        foreach ($data as $value) {
            $a_productos_formato[$value['id']] = $value;
        }
        $this->productos = $a_productos_formato;
    }

    public function seleccionar($index)
    {
        $this->producto_seleccionado = $this->productos[$index] ?? null;

        if ($this->producto_seleccionado) {
            $detalle_compra = DB::table('detalle_compras')
                ->join('productos', 'productos.id', '=', 'detalle_compras.producto_id')
                ->join('compras', 'compras.id', '=', 'detalle_compras.compra_id')
                ->where('detalle_compras.producto_id', $this->producto_seleccionado['id'])
                ->where('compras.estado', 1)
                ->selectRaw('compras.tipo, compras.fecha, productos.precio_compra, detalle_compras.cantidad, detalle_compras.subtotal, 0, 0, 0, detalle_compras.historial_stock');

            $this->detalle_kardex = DB::table('detalle_ventas')
                ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
                ->join('ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
                ->where('detalle_ventas.producto_id', $this->producto_seleccionado['id'])
                ->where('ventas.estado', 1)
                ->selectRaw('ventas.tipo as detalle, ventas.fecha as fecha, 0 as precio_ingreso, 0 cantidad_ingreso, 0 subtotal_ingreso, productos.precio_venta precio_salida, detalle_ventas.cantidad cantidad_salida, detalle_ventas.subtotal subtotal_salida, detalle_ventas.historial_stock stock')
                ->unionAll($detalle_compra)
                ->orderBy('fecha')
                ->get();
        }
        $this->nombre = '';
    }

    public function buscarKardexPorFecha(){
        $this->detalle_kardex = [];

        $detalle_compra = DB::table('detalle_compras')
            ->join('productos', 'productos.id', '=', 'detalle_compras.producto_id')
            ->join('compras', 'compras.id', '=', 'detalle_compras.compra_id')
            ->where('detalle_compras.producto_id', $this->producto_seleccionado['id'])
            ->where('compras.estado', 1)
            ->whereBetween('compras.fecha', [$this->fecha_ini, $this->fecha_fin ])
            ->selectRaw('compras.tipo, compras.fecha, productos.precio_compra, detalle_compras.cantidad, detalle_compras.subtotal, 0, 0, 0, detalle_compras.historial_stock');

        $this->detalle_kardex = DB::table('detalle_ventas')
            ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->join('ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
            ->where('detalle_ventas.producto_id', $this->producto_seleccionado['id'])
            ->where('ventas.estado', 1)
            ->whereBetween('ventas.fecha', [$this->fecha_ini, $this->fecha_fin ])
            ->selectRaw('ventas.tipo as detalle, ventas.fecha as fecha, 0 as precio_ingreso, 0 cantidad_ingreso, 0 subtotal_ingreso, productos.precio_venta precio_salida, detalle_ventas.cantidad cantidad_salida, detalle_ventas.subtotal subtotal_salida, detalle_ventas.historial_stock stock')
            ->unionAll($detalle_compra)
            ->orderBy('fecha')
            ->get();
    }
}
