<?php

    namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Compra;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;
use Exception;

    class DashboardController extends Controller
    {
        public function index()
        {
            $cantidad_productos = DB::table('productos')->count();

            $compras_realizadas = DB::table('compras')->count();

            $ventas_realizadas = DB::table('ventas')->count();

            $total_ventas_hoy = DB::table('ventas')
                ->where('fecha', date('Y-m-d'))
                ->sum('total');

            return view('pages/dashboard/dashboard', compact('cantidad_productos', 'compras_realizadas', 'ventas_realizadas', 'total_ventas_hoy'));
        }

        public function ingresosMes(Request $request){
            try {
                $fecha_inicio = empty($request['fecha_inicio']) ? Carbon::now()->startOfMonth() : $request['fecha_inicio'];
                $fecha_fin = empty($request['fecha_fin']) ? Carbon::now()->endOfMonth() : $request['fecha_fin'];

                $ingresosMes = DB::table('ventas')
                    ->where('estado', 1)
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->select(DB::raw("DATE_FORMAT(fecha, '%d %W') as mes, SUM(total) as total"))
                    ->groupBy('fecha')
                    ->orderBy('fecha','asc')
                    ->get();
                return response()->json($ingresosMes, 200);
            } catch (Exception $ex) {
                return response()->json($ex, 400);
            }
        }

        public function ingresosAnio(){
            try {
                $ingresosPorAnio = DB::table('ventas')
                    ->where('estado', 1)
                    ->whereYear('fecha', now('Y'))
                    ->select(DB::raw("DATE_FORMAT(fecha, '%M') as mes, DATE_FORMAT(fecha, '%m') as numeroMes, SUM(total) as total"))
                    ->groupBy('mes','numeroMes')
                    ->orderBy('numeroMes','asc')
                    ->get();

                return response()->json($ingresosPorAnio, 200);
            } catch (Exception $ex) {
                return response()->json($ex, 400);
            }
        }
    }
