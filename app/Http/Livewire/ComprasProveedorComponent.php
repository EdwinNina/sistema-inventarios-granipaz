<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use App\Models\Persona;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ComprasProveedorComponent extends Component
{
    use WithPagination;

    public $fecha_ini, $fecha_fin, $compras = [], $proveedor = '', $empresa;

    public function mount(){
        $this->empresa = Empresa::first();
        $this->fecha_ini = '';
        $this->fecha_fin = '';
    }

    public function render()
    {
        $proveedores = Persona::where('estado', 1)->where('tipo_persona', 'PROVEEDOR')->select('id', 'empresa')->get();

        return view('livewire.compras-proveedor-component', compact('proveedores'));
    }

    public function buscarComprasPorFecha()
    {
        if(empty($this->proveedor)) return $this->emit('existe', 'Debes seleccionar un proveedor para mostrar la informacion');

        if($this->fecha_ini !== "" && $this->fecha_fin !== ""){
            $compras = DB::table('detalle_compras')
                ->join('compras', 'compras.id', '=' ,'detalle_compras.compra_id')
                ->join('productos', 'productos.id', '=' ,'detalle_compras.producto_id')
                ->where('compras.proveedor_id', $this->proveedor)
                ->whereBetween('compras.fecha', [$this->fecha_ini, $this->fecha_fin])
                ->select('compras.codigo','compras.fecha', 'productos.nombre' ,'detalle_compras.cantidad', 'productos.precio_compra', 'detalle_compras.subtotal')
                ->get();
        }else{
            $compras = DB::table('detalle_compras')
                ->join('compras', 'compras.id', '=' ,'detalle_compras.compra_id')
                ->join('productos', 'productos.id', '=' ,'detalle_compras.producto_id')
                ->where('compras.proveedor_id', $this->proveedor)
                ->select('compras.codigo','compras.fecha', 'productos.nombre' ,'detalle_compras.cantidad', 'productos.precio_compra', 'detalle_compras.subtotal')
                ->get();
        }

        if(count($compras) == 0) return $this->emit('existe', 'El proveedor seleccionado no tiene compras vinculadas para mostrarlas');

        $this->compras = $compras;
    }
}
