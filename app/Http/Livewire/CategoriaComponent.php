<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\SubCategoria;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriaComponent extends Component
{
    use WithPagination;

    public $modalToggle = false, $subcategorias = [], $modalToggleSubProductos = false;

    protected $listeners = ['refreshData' => '$refresh'];

    public function render()
    {
        $categorias = Categoria::paginate(10);
        return view('livewire.categoria-component', compact('categorias'));
    }

    public function actualizarEstado(Categoria $categoria){
        $categoria->estado = !$categoria->estado;
        $categoria->save();
    }

    public function mostrarSubCategorias(Categoria $categoria){
        $this->subcategorias = SubCategoria::where('categoria_id', $categoria->id)->get();
        $this->modalToggleSubProductos = true;
    }

    public function cerrarModalSubCategorias(){
        $this->modalToggleSubProductos = false;
    }

    public function eliminarCategoria(Categoria $categoria){
        $a_subcategorias = $categoria->subcategorias;

        if(count($a_subcategorias)){
            $productos_sub = [];
            foreach ($a_subcategorias as $value) {
                $producto = Producto::where('sub_categoria_id', $value['id'])->first();
                if($producto){
                    $productos_sub[] = $value['nombre'];
                }
            }
            if(count($productos_sub) > 0){
                $this->emit('existe', 'No puedes eliminar esta categoria porque sus subcategorias '. implode($productos_sub) .' ya tiene productos asociados');
            }else{
                SubCategoria::where('categoria_id', $categoria->id)->delete();
                $categoria->delete();
                $this->emit('successMessage', 'eliminar');
            }
        }
    }
}
