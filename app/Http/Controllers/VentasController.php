<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Venta;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VentasFormRequest;
use Illuminate\Support\Facades\Auth;

class VentasController extends Controller
{
    public $clientes = '';

    public function __construct()
    {
        $this->clientes = Persona::where('estado', 1)
            ->where('tipo_persona', 'CLIENTE')
            ->select('id', 'empresa')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.ventas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = $this->clientes;
        return view('pages.ventas.create', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VentasFormRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $productos = $validated['productos'];
            $total_productos = [];
            $cantidad_productos = [];
            $detalle_venta = [];

            $venta = Venta::create([
                'fecha' => Carbon::parse($validated['fecha'])->format('Y-m-d'),
                'cliente_id' => $validated['cliente'],
                'user_id' => Auth::id()
            ]);

            foreach ($productos as $key => $producto) {
                $subtotal = $producto['cantidad'] * $producto['precio'];

                $detalle_venta[$key] = [
                    'medida' => $producto['medida'],
                    'cantidad' => $producto['cantidad'],
                    'precio_venta' => $producto['precio'],
                    'subtotal' => $subtotal,
                    'producto_id' => $producto['producto_id'],
                    'venta_id' => $venta->id
                ];
                $total_productos[] = $subtotal;
                $cantidad_productos[] = $productos[$key]['cantidad'];

                $producto_encontrado = Producto::find($producto['producto_id']);
                $producto_encontrado->stock = $producto_encontrado->stock - $producto['cantidad'];
                $producto_encontrado->save();

                $detalle_venta[$key]['historial_stock'] = $producto_encontrado->stock;
            }

            DetalleVenta::insert($detalle_venta);

            Venta::where('id', $venta->id)->update([
                'codigo' => str_pad("VENTA-". date('m-Y'). "-" . $venta->id, 10, "0", STR_PAD_LEFT),
                'nro_comprobante' => str_pad($venta->id, 10, "0", STR_PAD_LEFT),
                'total' => array_sum($total_productos),
                'cantidad' => array_sum($cantidad_productos),
                'user_id' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('ventas.index')->with('message', 'good');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->route('ventas.create')->with('message', 'error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        $detalle = DB::table('detalle_ventas')
            ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->select('detalle_ventas.id', 'detalle_ventas.medida', 'detalle_ventas.cantidad', 'detalle_ventas.subtotal', 'detalle_ventas.producto_id', 'productos.nombre', 'detalle_ventas.precio_venta', 'productos.stock', 'productos.descripcion')
            ->where('detalle_ventas.venta_id', $venta->id)->get();

        $clientes = $this->clientes;
        $productos = [];

        foreach ($detalle as $value) {
            $productos[$value->producto_id] = [
                'id'=> $value->producto_id,
                'nombre' => $value->nombre,
                'descripcion' => $value->descripcion,
                'medida' => $value->medida,
                'cantidad' => $value->cantidad,
                'precio' => $value->precio_venta,
                'stock' => $value->stock,
                'subtotal' => $value->subtotal
            ];
        }
        $total = $venta->total;

        return view('pages.ventas.edit', compact('venta', 'detalle', 'clientes', 'productos', 'total'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VentasFormRequest $request, Venta $venta)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $productos = $validated['productos'];
            $total_productos = [];
            $cantidad_productos = [];
            $detalle_venta = [];

            $detalle_modelo = DetalleVenta::where('venta_id', $venta->id);
            $detalle_antiguo = $detalle_modelo->get();

            foreach ($detalle_antiguo as $detalle) {
                $producto = Producto::find($detalle['producto_id']);
                $producto->stock = $producto->stock + $detalle['cantidad'];
                $producto->save();
            }

            $detalle_modelo->delete();

            foreach ($productos as $key => $producto) {
                $subtotal = $producto['cantidad'] * $producto['precio'];

                $detalle_venta[$key] = [
                    'cantidad' => $producto['cantidad'],
                    'medida' => $producto['medida'],
                    'subtotal' => $subtotal,
                    'producto_id' => $producto['producto_id'],
                    'venta_id' => $venta->id
                ];
                $total_productos[] = $subtotal;
                $cantidad_productos[] = $productos[$key]['cantidad'];

                $producto_encontrado = Producto::find($producto['producto_id']);
                $producto_encontrado->stock = $producto_encontrado->stock - $producto['cantidad'];
                $producto_encontrado->save();
                $detalle_venta[$key]['historial_stock'] = $producto_encontrado->stock;
            }

            DetalleVenta::insert($detalle_venta);

            $venta->fecha = Carbon::parse($validated['fecha'])->format('Y-m-d');
            $venta->cliente_id = $validated['cliente'];
            $venta->total = array_sum($total_productos);
            $venta->cantidad = array_sum($cantidad_productos);
            $venta->save();

            DB::commit();
            return redirect()->route('ventas.index')->with('message','good');
        } catch (Exception $ex) {
            DB::rollback();
            dd($ex);
            return redirect()->route('ventas.edit', $venta->id)->with('message','error');
        }
    }
}
