<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Livewire\Component;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\SubCategoria;
use Livewire\WithPagination;
use App\Models\DetalleCompra;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $modalToggle = false, $stock_minimo, $actualizar_imagen = false;
    public $productoId, $nombre, $descripcion, $sub_categoria_id, $imagen, $categoria_seleccionada;
    public $a_subcategorias, $modalToggleDetalle, $detalle;
    public $buscar = '', $filtrarSubCategoria = '';

    public function updatingBuscar() {
        $this->resetPage();
    }

    public function mount(){
        $this->categoria_seleccionada = '';
        $empresa = Empresa::first();
        $this->stock_minimo = ($empresa) ? $empresa->stock_minimo : 10;
        $this->a_subcategorias = [];
        $this->modalToggleDetalle = false;
    }

    public function render()
    {
        $productos = DB::table('productos')
            ->when($this->buscar, function($query){
                return $query->where('productos.nombre', 'like', '%'. $this->buscar.'%');
            })
            ->when(!empty($this->filtrarSubCategoria), function($query){
                return $query->where('productos.sub_categoria_id', $this->filtrarSubCategoria);
            })
            ->join('sub_categorias', 'sub_categorias.id','=','productos.sub_categoria_id')
            ->join('categorias', 'categorias.id','=','sub_categorias.categoria_id')
            ->select('productos.*','sub_categorias.nombre as sub_categoria', 'categorias.nombre as categoria')
            ->orderBy('nombre')
            ->paginate(5);

        $categorias = Categoria::where('estado', 1)->select('id', 'nombre')->get();

        return view('livewire.producto-component', compact('productos', 'categorias'));
    }

    private function resetInputs(){
        $this->nombre = '';
        $this->descripcion = '';
        $this->sub_categoria_id = '';
        $this->categoria_seleccionada = '';
        $this->imagen = '';
    }

    public function rules(){
        return [
            'nombre' => 'required',
            'sub_categoria_id' => 'required',
            'imagen' => 'required|image|max:2048',
        ];
    }

    public function abrirModal(){
        $this->resetInputs();
        $this->resetValidation();
        $this->modalToggle = true;
    }

    public function cerrarModal(){
        $this->modalToggle = false;
    }

    public function guardar(){
        $this->validate();
        Producto::create([
            'nombre' => mb_strtolower($this->nombre),
            'descripcion' => mb_strtolower($this->descripcion),
            'sub_categoria_id' => $this->sub_categoria_id,
            'imagen' => $this->imagen->store('productos','public'),
        ]);
        $this->resetInputs();
        $this->actualizar_imagen = false;
        $this->cerrarModal();
        $this->emit('successMessage', 'crear');
    }

    public function updatedImagen()
    {
        $this->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $this->actualizar_imagen = true;
    }

    public function editar(Producto $producto){
        $subcategoria = SubCategoria::where('id', $producto->sub_categoria_id)->select('categoria_id')->first();
        $this->categoria_seleccionada = $subcategoria['categoria_id'];

        $this->filtrarSubCategoria($subcategoria['categoria_id']);
        $this->resetValidation();
        $this->productoId = $producto->id;
        $this->nombre = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->sub_categoria_id = $producto->sub_categoria_id;
        $this->imagen = $producto->imagen;
        $this->modalToggle = true;
    }

    public function actualizar(){
        $producto = Producto::find($this->productoId);
        $producto->nombre = $this->nombre;
        $producto->descripcion = $this->descripcion;
        $producto->sub_categoria_id = $this->sub_categoria_id;

        if($this->actualizar_imagen){
            Storage::disk('public')->delete($producto->imagen);
            $producto->imagen = $this->imagen->store('productos', 'public');
        }

        $producto->save();
        $this->actualizar_imagen = false;
        $this->resetValidation();
        $this->cerrarModal();
        $this->emit('successMessage', 'actualizar');
    }

    public function actualizarEstado(Producto $producto){
        $producto->estado = !$producto->estado;
        $producto->save();
    }

    public function eliminarCategoria(Producto $producto){
        $compras = DetalleCompra::where('producto_id', $producto->id)->get();

        if(count($compras) === 0){
            $producto->delete();
            $this->emit('successMessage', 'eliminar');
        }else{
            $this->emit('existe', 'No puedes eliminar esta producto porque ya ingresos realizados');
        }
    }

    public function filtrarSubCategoria($categoria){
        $this->a_subcategorias = SubCategoria::where(['categoria_id' => $categoria, 'estado' => 1])->select('id', 'nombre')->get();
    }

    public function mostrarProducto(Producto $producto)
    {
        $this->detalle = $producto;
        $this->modalToggleDetalle = true;
    }
}
