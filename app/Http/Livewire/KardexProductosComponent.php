<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Livewire\Component;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\SubCategoria;
use Illuminate\Support\Facades\DB;

class KardexProductosComponent extends Component
{
    public $nombre, $productos, $categorias, $detalle_kardex, $stock_minimo, $producto_seleccionado, $a_subcategorias, $sub_categoria_id;
    public $fecha_ini, $fecha_fin;

    public function mount()
    {
        $empresa = Empresa::first();
        $this->categorias = Categoria::where('estado', 1)->select('id','nombre')->get();
        $this->resetBusqueda();
        $this->stock_minimo = $empresa->stock_minimo;
        $this->a_subcategorias = [];
    }

    public function render()
    {
        return view('livewire.kardex-productos-component');
    }

    public function resetBusqueda(){
        $this->nombre = '';
        $this->sub_categoria_id = '';
        $this->producto_seleccionado = [];
        $this->productos = [];
        $this->detalle_kardex = [];
        $this->fecha_ini = '';
        $this->fecha_fin = '';
    }

    public function updatedSubCategoriaId(){
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
                $query->where('sub_categoria_id', $this->filtrarCategoria);
            })
            ->with('subcategoria')
            ->where('estado', 1)
            ->get()
            ->toArray();
        $a_productos_formato = [];
        foreach ($data as $value) {
            $a_productos_formato[$value['id']] = $value;
        }
        $this->productos = $a_productos_formato;
    }

    public function filtrarSubCategoria($categoria){
        $this->a_subcategorias = SubCategoria::where(['categoria_id' => $categoria, 'estado' => 1])->select('id', 'nombre')->get();
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
                ->selectRaw('compras.tipo, compras.fecha, detalle_compras.cantidad, detalle_compras.subtotal, 0, 0, detalle_compras.historial_stock, productos.precio_unitario, compras.created_at');

            $this->detalle_kardex = DB::table('detalle_ventas')
                ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
                ->join('ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
                ->where('detalle_ventas.producto_id', $this->producto_seleccionado['id'])
                ->where('ventas.estado', 1)
                ->selectRaw('ventas.tipo as detalle, ventas.fecha as fecha, 0 cantidad_ingreso, 0 subtotal_ingreso, detalle_ventas.cantidad cantidad_salida, detalle_ventas.subtotal subtotal_salida, detalle_ventas.historial_stock stock, productos.precio_unitario, ventas.created_at as fecha_hora')
                ->unionAll($detalle_compra)
                ->orderByRaw('fecha, fecha_hora')
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
            ->selectRaw('compras.tipo, compras.fecha, detalle_compras.cantidad, detalle_compras.subtotal, 0, 0, detalle_compras.historial_stock, productos.precio_unitario');

        $this->detalle_kardex = DB::table('detalle_ventas')
            ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->join('ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
            ->where('detalle_ventas.producto_id', $this->producto_seleccionado['id'])
            ->where('ventas.estado', 1)
            ->whereBetween('ventas.fecha', [$this->fecha_ini, $this->fecha_fin ])
            ->selectRaw('ventas.tipo as detalle, ventas.fecha as fecha, 0 cantidad_ingreso, 0 subtotal_ingreso, detalle_ventas.cantidad cantidad_salida, detalle_ventas.subtotal subtotal_salida, detalle_ventas.historial_stock stock, productos.precio_unitario')
            ->unionAll($detalle_compra)
            ->orderBy('fecha')
            ->get();
    }
}
