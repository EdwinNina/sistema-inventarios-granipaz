<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CheckUserRoleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login')->name('login');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/productos', function () { return view('pages.productos.index'); })->name('productos.index');
    Route::get('/proveedores', function () { return view('pages.proveedor.index'); })->name('proveedores.index');
    Route::get('/clientes', function () { return view('pages.clientes.index'); })->name('clientes.index');
    Route::get('/kardex-productos', function () { return view('pages.inventarios.kardex-producto'); })->name('inventarios.kardex-producto');
    Route::get('/compras-proveedor', function () { return view('pages.inventarios.compras-proveedor'); })->name('inventarios.compras-proveedor');
    Route::get('/reporte-ventas', function () { return view('pages.reportes.reporte-ventas'); })->name('reportes.reporte-ventas');
    Route::get('/reporte-compras', function () { return view('pages.reportes.reporte-compras'); })->name('reportes.reporte-compras');
    Route::get('/empresa', function () { return view('pages.empresa.index'); })->name('empresa.index');

    Route::get('/usuarios', function () { return view('pages.usuarios.index'); })->name('usuarios.index');
    Route::get('/roles', function () { return view('pages.roles.index'); })->name('roles.index');

    // Route::get('/compras', [ComprasController::class, 'index'])->name('compras.index');
    // Route::get('/compras/nuevaCompra', [ComprasController::class, 'create'])->name('compras.create');
    // Route::post('/compras', [ComprasController::class, 'store'])->name('compras.store');
    // Route::get('/compras/edit/{compra}', [ComprasController::class, 'edit'])->name('compras.edit');
    // Route::put('/compras/{compra}', [ComprasController::class, 'update'])->name('compras.update');

    Route::resource('/compras', ComprasController::class)->names('compras')->except('show');
    Route::resource('/categorias', CategoriaController::class)->names('categorias')->except('show');
    Route::resource('/ventas', VentasController::class)->names('ventas')->except('show');

    Route::get('/reporte-productos', [ReportesController::class, 'imprimirReporteProductos'])->name('reporte.productos');
    Route::post('/reporte-compras-proveedor', [ReportesController::class, 'imprimirReporteComprasProveedor'])->name('reporte.compras-proveedor');
    Route::post('/reporte-kardex-producto', [ReportesController::class, 'imprimirReporteKardexProducto'])->name('reporte.kardex-producto');
    Route::post('/reporte-compra-individual', [ReportesController::class, 'imprimirReporteCompraIndividual'])->name('reporte.compra-individual');
    Route::post('/reporte-venta-individual', [ReportesController::class, 'imprimirReporteVentasIndividual'])->name('reporte.venta-individual');

    Route::post('/ingresos-mes', [DashboardController::class, 'ingresosMes'])->name('dashboard.ingresos-mes');
    Route::post('/ingresos-anio', [DashboardController::class, 'ingresosAnio'])->name('dashboard.ingresos-anio');

    Route::fallback(function () { return view('pages/utility/404'); });
});
