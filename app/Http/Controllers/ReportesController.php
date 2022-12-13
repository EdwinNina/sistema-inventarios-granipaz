<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use NumeroALetras;
use App\Models\Empresa;
use App\Models\Persona;
use App\Models\Producto;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public $fpdf;

    public function __construct() {
        $empresa = Empresa::first();

        $this->fpdf = new Fpdf('P','mm','Letter');
        $this->fpdf->AddPage();
        $this->fpdf->SetAutoPageBreak(true,25);
        $this->fpdf->Image('storage/'. $empresa->logotipo ,10,7,22,22);
        $this->fpdf->SetFont('Arial','B',14);
        $this->fpdf->Cell(0,12, Str::title($empresa->empresa),0,0, 'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(0,12, Str::title($empresa->direccion) ,0,0,'C');
        $this->fpdf->Ln(3);
        $this->fpdf->Cell(0,12, 'Correo: '. $empresa->correo ,0,0,'C');
        $this->fpdf->Ln(3);
        $this->fpdf->Cell(0,13, 'Celular: '. $empresa->celular,0,0,'C');
        $this->fpdf->SetLineWidth(0.5);
        $this->fpdf->Line(10,32,200,32);
        $this->fpdf->Ln(15);
    }

    public function imprimirReporteProductos(){
        $productos = Producto::with('subcategoria')->get();

        $this->fpdf->SetFont('Arial','B',12);
        $this->fpdf->Cell(0,10,'REPORTE DE PRODUCTOS',0,0,'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial','B', 10);
        $this->fpdf->SetFillColor(232,232,232);
        $this->fpdf->Cell(60,8,'Nombre',1,0,'C',true);
        $this->fpdf->Cell(50,8,'Descripcion',1,0,'C',true);
        $this->fpdf->Cell(10,8,'P.U.',1,0,'C',true);
        $this->fpdf->Cell(14,8,'Stock',1,0,'C',true);
        $this->fpdf->Cell(33,8,'Categoria',1,0,'C',true);
        $this->fpdf->Cell(15,8,'Est',1,0,'C',true);
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Arial','',6);
        foreach ($productos as $producto) {
            $cellWidth=50;//wrapped cell width
            $cellHeight=8;//normal one-line cell height

            //check whether the text is overflowing
            if($this->fpdf->GetStringWidth($producto->descripcion) < $cellWidth){
                $line=1;
            }else{
                $textLength = strlen($producto->descripcion);	//total text length
                $errMargin=10;		//cell width error margin, just in case
                $startChar=0;		//character start position for each line
                $maxChar=0;			//maximum character in a line, to be incremented later
                $textArray=array();	//to hold the strings for each line
                $tmpString="";		//to hold the string for a line (temporary)

                while($startChar < $textLength){ //loop until end of text
                    //loop until maximum character reached
                    while(
                    $this->fpdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
                    ($startChar+$maxChar) < $textLength ) {
                        $maxChar++;
                        $tmpString=substr($producto->descripcion,$startChar,$maxChar);
                    }
                    //move startChar to next line
                    $startChar=$startChar+$maxChar;
                    //then add it into the array so we know how many line are needed
                    array_push($textArray,$tmpString);
                    //reset maxChar and tmpString
                    $maxChar=0;
                    $tmpString='';
                }
                //get number of line
                $line=count($textArray);
            }
            $this->fpdf->Cell(60,($line * $cellHeight), utf8_decode($producto->nombre),1);

            $xPos=$this->fpdf->GetX();
        	$yPos=$this->fpdf->GetY();
            $this->fpdf->MultiCell($cellWidth,$cellHeight, utf8_decode($producto->descripcion),1);
            $this->fpdf->SetXY($xPos + $cellWidth , $yPos);

            $this->fpdf->Cell(10,($line * $cellHeight), $producto->precio_unitario,1,0,'C');
            $this->fpdf->Cell(14,($line * $cellHeight), $producto->stock,1,0,'C');
            $this->fpdf->Cell(33,($line * $cellHeight), $producto->subcategoria->nombre,1,0);
            $this->fpdf->Cell(15,($line * $cellHeight), $producto->estado ? 'Activo' : 'Inactivo' ,1,0,'C');
            $this->fpdf->Ln();
        }
        $this->fpdf->Output('D');
        exit;
    }

    public function imprimirReporteComprasProveedor(Request $request){
        $proveedor = $request['proveedor'];

        if(empty($proveedor)) return redirect()->back()->with('mensaje', 'error');

        $fecha_ini = $request['fecha_ini'];
        $fecha_fin = $request['fecha_fin'];
        $persona = Persona::find($proveedor);

        $query = DB::table('detalle_compras')
            ->join('compras', 'compras.id', '=' ,'detalle_compras.compra_id')
            ->join('productos', 'productos.id', '=' ,'detalle_compras.producto_id')
            ->where('compras.proveedor_id', $proveedor);

        if(!empty($fecha_ini) && !empty($fecha_fin)){ $query->whereBetween('compras.fecha', [$fecha_ini, $fecha_fin]); }

        $compras = $query->select('compras.codigo','compras.fecha', 'productos.nombre' ,'detalle_compras.cantidad', 'productos.precio_unitario', 'detalle_compras.subtotal')->get();

        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->Cell(10,10,'Datos del Proveedor',0,0,);
        $this->fpdf->Ln(13);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(20,5,'Empresa o Razon Social:'. $persona->empresa);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Correo electronico:'. $persona->email);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Celular:'. $persona->celular);
        $this->fpdf->Ln();
            $nombre_completo = $persona->paterno.' '.$persona->materno.' '.$persona->nombre;
        $this->fpdf->Cell(20,5,'Nombre Completo:'. $nombre_completo);
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial','B',12);
        $this->fpdf->Cell(0,10,'REPORTE DE PRODUCTOS POR PROVEEDOR',0,0,'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial','B', 10);
        $this->fpdf->SetFillColor(232,232,232);
        $this->fpdf->SetTextColor(40,40,40);
        $this->fpdf->SetDrawColor(88,88,88);
        $this->fpdf->Cell(50,8,'Codigo',1,0,'C',true);
        $this->fpdf->Cell(40,8,'Fecha.',1,0,'C',true);
        $this->fpdf->Cell(35,8,'Cantidad',1,0,'C',true);
        $this->fpdf->Cell(35,8,'Precio',1,0,'C',true);
        $this->fpdf->Cell(35,8,'Subtotal',1,0,'C',true);
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Arial','',8);

        $a_monto = [];
        foreach ($compras as $compra) {
            $this->fpdf->Cell(50,8, $compra->codigo,1,0);
            $this->fpdf->Cell(40,8, Carbon::parse($compra->fecha)->format('d-m-Y') ,1,0,'C');
            $this->fpdf->Cell(35,8, $compra->cantidad,1,0,'C');
            $this->fpdf->Cell(35,8, $compra->precio_unitario,1,0,'C');
            $this->fpdf->Cell(35,8, $compra->subtotal,1,0);
            $this->fpdf->Ln();
            $a_monto[] = $compra->subtotal;
        }
        $total_monto = array_sum($a_monto);

        $this->fpdf->Cell(160,8, 'Total',1,0);
        $this->fpdf->Cell(35,8, $total_monto ,1,0);
        $this->fpdf->Ln(13);
        $this->fpdf->SetFont('Arial','B', 8);
        $this->fpdf->Cell(20,6,utf8_decode('La suma de:'),0,0,'L');
        $this->fpdf->SetFont('Arial','', 8);
        $this->fpdf->Cell(140,6,utf8_decode(NumeroALetras::convertir($total_monto)),0,0,'');
        $this->fpdf->SetFont('Arial','B', 8);
        $this->fpdf->Cell(30,6,utf8_decode('Bolivianos / $us'),0,1,'C');
        $this->fpdf->Ln(2);
        $this->fpdf->Output('D');
        exit;
    }

    function get_detalle_kardex($producto_id, $fecha_ini, $fecha_fin){
        $query = DB::table('detalle_compras')
            ->join('productos', 'productos.id', '=', 'detalle_compras.producto_id')
            ->join('compras', 'compras.id', '=', 'detalle_compras.compra_id')
            ->where('detalle_compras.producto_id', $producto_id)
            ->where('compras.estado', 1);

        if (!empty($fecha_ini) && !empty($fecha_fin)) { $query->whereBetween('compras.fecha', [$fecha_ini, $fecha_fin ]); }

        $detalle_compra = $query->selectRaw('compras.tipo, compras.fecha, detalle_compras.cantidad, detalle_compras.subtotal, 0, 0, detalle_compras.historial_stock, productos.precio_unitario');

        $query = DB::table('detalle_ventas')
            ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->join('ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
            ->where('detalle_ventas.producto_id', $producto_id)
            ->where('ventas.estado', 1);

        if (!empty($fecha_ini) && !empty($fecha_fin)) { $query->whereBetween('ventas.fecha', [$fecha_ini, $fecha_fin ]); }

        return $query->selectRaw('ventas.tipo as detalle, ventas.fecha as fecha, 0 cantidad_ingreso, 0 subtotal_ingreso, detalle_ventas.cantidad cantidad_salida, detalle_ventas.subtotal subtotal_salida, detalle_ventas.historial_stock stock, productos.precio_unitario')
            ->unionAll($detalle_compra)
            ->orderBy('fecha')
            ->get();
    }

    public function imprimirReporteKardexProducto(Request $request){
        $producto_seleccionado = $request['producto'];

        $producto = Producto::where('id', $producto_seleccionado)->with('subcategoria')->first()->toArray();

        $detalle_kardex = $this->get_detalle_kardex($producto_seleccionado, $request['fecha_ini'], $request['fecha_fin']);

        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->Cell(10,10,'Datos del Producto',0,0,);
        $this->fpdf->Ln(13);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(20,5,'Nombre: '. $producto['nombre']);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Detalle: '. $producto['descripcion']);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Sub Categoria:'. $producto['subcategoria']['nombre']);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Precio Uni: '. $producto['precio_unitario']);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Stock Actual: '. $producto['stock']);
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial','B',12);
        $this->fpdf->Cell(0,10,'REPORTE DE KARDEX DE PRODUCTO' ,0,0,'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial','B', 10);
        $this->fpdf->SetFillColor(232,232,232);
        $this->fpdf->SetTextColor(40,40,40);
        $this->fpdf->SetDrawColor(88,88,88);
        $this->fpdf->Cell(50,8,'',1,0,'C',true);
        $this->fpdf->Cell(60,8,'Entrada',1,0,'C',true);
        $this->fpdf->Cell(60,8,'Salida',1,0,'C',true);
        $this->fpdf->Cell(20,8,'Saldo',1,0,'C',true);
        $this->fpdf->Ln();
        $this->fpdf->SetFillColor(232,300,232);
        $this->fpdf->Cell(30,8,'Fecha',1,0,'C',true);
        $this->fpdf->Cell(20,8,'Detalle',1,0,'C',true);
        $this->fpdf->Cell(20,8,'Cantidad',1,0,'C',true);
        $this->fpdf->Cell(20,8,'Precio',1,0,'C',true);
        $this->fpdf->Cell(20,8,'Subtotal',1,0,'C',true);
        $this->fpdf->Cell(20,8,'Cantidad',1,0,'C',true);
        $this->fpdf->Cell(20,8,'Precio',1,0,'C',true);
        $this->fpdf->Cell(20,8,'Subtotal',1,0,'C',true);
        $this->fpdf->Cell(20,8,'Stock',1,0,'C',true);
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Arial','',8);

        foreach ($detalle_kardex as $kardex) {
            $this->fpdf->Cell(30,8, Carbon::parse($kardex->fecha)->format('d-m-Y') ,1,0,'C');
            $this->fpdf->Cell(20,8, $kardex->detalle,1,0);
            $this->fpdf->Cell(20,8, $kardex->cantidad_ingreso,1,0,'C');
            $this->fpdf->Cell(20,8, $kardex->precio_unitario,1,0,'C');
            $this->fpdf->Cell(20,8, $kardex->subtotal_ingreso,1,0,'C');
            $this->fpdf->Cell(20,8, $kardex->cantidad_salida,1,0,'C');
            $this->fpdf->Cell(20,8, $kardex->precio_unitario,1,0,'C');
            $this->fpdf->Cell(20,8, $kardex->subtotal_salida,1,0,'C');
            $this->fpdf->Cell(20,8, $kardex->stock,1,0, 'C');
            $this->fpdf->Ln();
        }

        $this->fpdf->Output('D');
        exit;
    }

    public function imprimirReporteCompraIndividual(Request $request){
        $compra_id = $request['compra_id'];

        $compra = DB::table('compras')
            ->join('personas','personas.id', '=', 'compras.proveedor_id')
            ->selectRaw('compras.codigo, compras.nro_comprobante, compras.cantidad, compras.total, compras.fecha, personas.empresa')
            ->where('compras.id', $compra_id)
            ->get()->toArray();
        $compra = $compra[0];

        $detalle_compra = DB::table('detalle_compras')
            ->join('compras', 'compras.id', '=', 'detalle_compras.compra_id')
            ->join('productos', 'productos.id', '=', 'detalle_compras.producto_id')
            ->selectRaw('productos.nombre, productos.precio_unitario, detalle_compras.cantidad, detalle_compras.subtotal')
            ->where('compras.id', $compra_id)
            ->get();

        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->Cell(10,10,'Datos de la Compra',0,0,);
        $this->fpdf->Ln(13);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(20,5,'Codigo: '. $compra->codigo);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Fecha: '. Carbon::parse($compra->fecha)->format('d-m-Y') );
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Nro comprobante: '. $compra->nro_comprobante);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Cantidad Total: '. $compra->cantidad);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Total: '. $compra->total);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Proveedor: '. Str::title($compra->empresa));
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial','B',12);
        $this->fpdf->Cell(0,10,'LISTA DE PRODUCTOS ADQUIRIDOS',0,0,'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial','B', 10);
        $this->fpdf->SetFillColor(232,232,232);
        $this->fpdf->SetTextColor(40,40,40);
        $this->fpdf->SetDrawColor(88,88,88);
        $this->fpdf->Cell(65,8,'Nombre',1,0,'C',true);
        $this->fpdf->Cell(40,8,'Precio',1,0,'C',true);
        $this->fpdf->Cell(40,8,'Cantidad',1,0,'C',true);
        $this->fpdf->Cell(40,8,'Subtotal',1,0,'C',true);
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Arial','',8);

        foreach ($detalle_compra as $detalle) {
            $this->fpdf->Cell(65,8, $detalle->nombre,1,0);
            $this->fpdf->Cell(40,8, $detalle->precio_unitario,1,0,'C');
            $this->fpdf->Cell(40,8, $detalle->cantidad,1,0,'C');
            $this->fpdf->Cell(40,8, $detalle->subtotal,1,0,'C');
            $this->fpdf->Ln();
        }

        $this->fpdf->Cell(145,8, 'Total',1,0);
        $this->fpdf->Cell(40,8, $compra->total ,1,0, 'C');
        $this->fpdf->Ln(13);
        $this->fpdf->SetFont('Arial','B', 8);
        $this->fpdf->Cell(20,6,utf8_decode('La suma de:'),0,0,'L');
        $this->fpdf->SetFont('Arial','', 8);
        $this->fpdf->Cell(140,6,utf8_decode(NumeroALetras::convertir($compra->total)),0,0,'');
        $this->fpdf->SetFont('Arial','B', 8);
        $this->fpdf->Cell(30,6,utf8_decode('Bolivianos / $us'),0,1,'C');
        $this->fpdf->Ln(2);

        $this->fpdf->Output('D');
        exit;
    }

    public function imprimirReporteVentasIndividual(Request $request){
        $venta_id = $request['venta_id'];

        $venta = DB::table('ventas')
            ->join('personas','personas.id', '=', 'ventas.cliente_id')
            ->selectRaw('ventas.codigo, ventas.tipo_comprobante, ventas.nro_comprobante, ventas.cantidad, ventas.total, ventas.fecha, personas.empresa')
            ->where('ventas.id', $venta_id)
            ->get()->toArray();
        $venta = $venta[0];

        $detalle_venta = DB::table('detalle_ventas')
            ->join('ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
            ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->selectRaw('productos.nombre, productos.precio_unitario, detalle_ventas.cantidad, detalle_ventas.subtotal')
            ->where('ventas.id', $venta_id)
            ->get();

        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->Cell(10,10,'Datos de la Venta',0,0,);
        $this->fpdf->Ln(13);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(20,5,'Codigo: '. $venta->codigo);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Fecha: '. Carbon::parse($venta->fecha)->format('d-m-Y') );
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Tipo de Comprobante: '. $venta->tipo_comprobante);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Nro comprobante: '. $venta->nro_comprobante);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Cantidad Total: '. $venta->cantidad);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Total: '. $venta->total);
        $this->fpdf->Ln();
        $this->fpdf->Cell(20,5,'Cliente: '. Str::title($venta->empresa));
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial','B',12);
        $this->fpdf->Cell(0,10,'LISTA DE PRODUCTOS VENDIDOS',0,0,'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial','B', 10);
        $this->fpdf->SetFillColor(232,232,232);
        $this->fpdf->SetTextColor(40,40,40);
        $this->fpdf->SetDrawColor(88,88,88);
        $this->fpdf->Cell(65,8,'Nombre',1,0,'C',true);
        $this->fpdf->Cell(40,8,'Precio',1,0,'C',true);
        $this->fpdf->Cell(40,8,'Cantidad',1,0,'C',true);
        $this->fpdf->Cell(40,8,'Subtotal',1,0,'C',true);
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Arial','',8);

        foreach ($detalle_venta as $detalle) {
            $this->fpdf->Cell(65,8, $detalle->nombre,1,0);
            $this->fpdf->Cell(40,8, $detalle->precio_unitario,1,0,'C');
            $this->fpdf->Cell(40,8, $detalle->cantidad,1,0,'C');
            $this->fpdf->Cell(40,8, $detalle->subtotal,1,0,'C');
            $this->fpdf->Ln();
        }

        $this->fpdf->Cell(145,8, 'Total',1,0);
        $this->fpdf->Cell(40,8, $venta->total ,1,0,'C');
        $this->fpdf->Ln(13);
        $this->fpdf->SetFont('Arial','B', 8);
        $this->fpdf->Cell(20,6,utf8_decode('La suma de:'),0,0,'L');
        $this->fpdf->SetFont('Arial','', 8);
        $this->fpdf->Cell(140,6,utf8_decode(NumeroALetras::convertir($venta->total)),0,0,'');
        $this->fpdf->SetFont('Arial','B', 8);
        $this->fpdf->Cell(30,6,utf8_decode('Bolivianos / $us'),0,1,'C');
        $this->fpdf->Ln(2);

        $this->fpdf->Output('D');
        exit;
    }
}
