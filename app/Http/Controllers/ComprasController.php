<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Compra;
use App\Models\DetalleCompra;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ComprasFormRequest;
use App\Models\Persona;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class ComprasController extends Controller
{
    public $proveedores = '';

    public function __construct()
    {
        $this->proveedores = Persona::where('estado', 1)->where('tipo_persona', 'PROVEEDOR')->select('id', 'empresa')->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.compras.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = $this->proveedores;

        return view('pages.compras.create', compact('proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComprasFormRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $productos = $validated['productos'];
            $total_productos = [];
            $cantidad_productos = [];
            $detalle_compra = [];

            $compra = Compra::create([
                'fecha' => Carbon::parse($validated['fecha'])->format('Y-m-d'),
                'proveedor_id' => $validated['proveedor'],
                'user_id' => Auth::id()
            ]);

            foreach ($productos as $key => $producto) {
                $subtotal = $producto['cantidad'] * $producto['precio'];

                $detalle_compra[$key] = [
                    'medida' => $producto['medida'],
                    'cantidad' => $producto['cantidad'],
                    'subtotal' => $subtotal,
                    'producto_id' => $producto['producto_id'],
                    'compra_id' => $compra->id
                ];
                $total_productos[] = $subtotal;
                $cantidad_productos[] = $productos[$key]['cantidad'];

                $producto_encontrado = Producto::find($producto['producto_id']);
                $producto_encontrado->stock = $producto_encontrado->stock + $producto['cantidad'];
                $producto_encontrado->save();

                $detalle_compra[$key]['historial_stock'] = $producto_encontrado->stock;
            }

            DetalleCompra::insert($detalle_compra);

            Compra::where('id', $compra->id)->update([
                'codigo' => str_pad("COMPRA-". date('m-Y'). "-" . $compra->id, 10, "0", STR_PAD_LEFT),
                'nro_comprobante' => str_pad($compra->id, 10, "0", STR_PAD_LEFT),
                'total' => array_sum($total_productos),
                'cantidad' => array_sum($cantidad_productos),
            ]);

            DB::commit();
            return redirect()->route('compras.index')->with('message', 'good');
        } catch (Exception $ex) {
            dd($ex);
            DB::rollback();
            return redirect()->route('compras.create')->with('message', 'error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        $detalle = DB::table('detalle_compras')
            ->join('productos', 'productos.id', '=', 'detalle_compras.producto_id')
            ->select('detalle_compras.id', 'detalle_compras.cantidad', 'detalle_compras.subtotal', 'detalle_compras.producto_id', 'productos.nombre', 'productos.precio_unitario', 'productos.descripcion', 'detalle_compras.medida', 'productos.stock')
            ->where('detalle_compras.compra_id', $compra->id)->get();

        $proveedores = $this->proveedores;
        $productos = [];

        foreach ($detalle as $value) {
            $productos[$value->producto_id] = [
                'id'=> $value->producto_id,
                'nombre' => $value->nombre,
                'descripcion' => $value->descripcion,
                'cantidad' => $value->cantidad,
                'precio' => $value->precio_unitario,
                'medida' => $value->medida,
                'stock' => $value->stock,
                'subtotal' => $value->subtotal
            ];
        }
        $total = $compra->total;

        return view('pages.compras.edit', compact('compra', 'detalle', 'proveedores', 'productos', 'total'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComprasFormRequest $request, Compra $compra)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $productos = $validated['productos'];
            $total_productos = [];
            $cantidad_productos = [];
            $detalle_compra = [];

            $detalle_modelo = DetalleCompra::where('compra_id', $compra->id);
            $detalle_antiguo = $detalle_modelo->get();

            foreach ($detalle_antiguo as $detalle) {
                $producto = Producto::find($detalle['producto_id']);
                $producto->stock = $producto->stock - $detalle['cantidad'];
                $producto->save();
            }

            $detalle_modelo->delete();

            foreach ($productos as $key => $producto) {
                $subtotal = $producto['cantidad'] * $producto['precio'];

                $detalle_compra[$key] = [
                    'cantidad' => $producto['cantidad'],
                    'subtotal' => $subtotal,
                    'producto_id' => $producto['producto_id'],
                    'compra_id' => $compra->id
                ];
                $total_productos[] = $subtotal;
                $cantidad_productos[] = $productos[$key]['cantidad'];

                $producto_encontrado = Producto::find($producto['producto_id']);
                $producto_encontrado->stock = $producto_encontrado->stock + $producto['cantidad'];
                $producto_encontrado->save();
                $detalle_compra[$key]['historial_stock'] = $producto_encontrado->stock;
            }

            DetalleCompra::insert($detalle_compra);

            $compra->fecha = Carbon::parse($validated['fecha'])->format('Y-m-d');
            $compra->proveedor_id = $validated['proveedor'];
            $compra->total = array_sum($total_productos);
            $compra->cantidad = array_sum($cantidad_productos);
            $compra->save();

            DB::commit();
            return redirect()->route('compras.index')->with('message','good');
        } catch (Exception $ex) {
            dd($ex);
            DB::rollback();
            return redirect()->route('compras.edit')->with('message','error');
        }
    }
}
