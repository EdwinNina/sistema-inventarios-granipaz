<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\Persona;
use Livewire\Component;
use App\Models\Proveedor;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProveedorComponent extends Component
{
    use WithPagination;

    public $modalToggle = false, $buscar = '';
    public $nombre, $paterno, $materno, $tipo_documento, $nro_documento, $complemento, $empresa, $email, $celular, $persona_id, $tipo_persona;

    public function mount($tipo_persona)
    {
        $this->tipo_persona = $tipo_persona;
    }

    public function render()
    {
        $proveedores = Persona::query()
            ->when($this->buscar, function($query){
                return $query->where('nombre', 'like', '%' . $this->buscar . '%')
                    ->orWhere('paterno', 'like', '%' . $this->buscar . '%')
                    ->orWhere('materno', 'like', '%' . $this->buscar . '%')
                    ->orWhere('empresa', 'like', '%' . $this->buscar . '%');
            })
            ->where('tipo_persona', $this->tipo_persona)
            ->paginate();

        return view('livewire.proveedor-component', compact('proveedores'));
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    private function resetInputs(){
        $this->nombre = '';
        $this->paterno = '';
        $this->materno = '';
        $this->tipo_documento = '';
        $this->nro_documento = '';
        $this->complemento = '';
        $this->empresa = '';
        $this->email = '';
        $this->celular = '';
    }

    public function rules(){
        return [
            'nombre' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'nro_documento' => ['required', Rule::unique('personas','nro_documento')->ignore($this->persona_id)],
            'tipo_documento' => 'required',
            'empresa' => 'required',
            'email' => 'required',
            'celular' => 'required',
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
        $persona = Persona::create([
            'nombre' => mb_strtolower($this->nombre),
            'paterno' => mb_strtolower($this->paterno),
            'materno' => mb_strtolower($this->materno),
            'tipo_documento' => $this->tipo_documento,
            'nro_documento' => $this->nro_documento,
            'complemento' => $this->complemento,
            'empresa' => mb_strtolower($this->empresa),
            'email' => $this->email,
            'celular' => $this->celular,
            'tipo_persona' => $this->tipo_persona,
        ]);
        if($persona){
            $this->resetInputs();
            $this->cerrarModal();
            $this->emit('successMessage', 'crear');
        }else{
            $this->emit('exito', 'Ocurrio un error al crear el recurso intentelo nuevamente');
        }
    }

    public function editar(Persona $persona){
        $this->resetValidation();
        $this->persona_id = $persona->id;
        $this->nombre = ucfirst($persona->nombre);
        $this->paterno = ucfirst($persona->paterno);
        $this->materno = ucfirst($persona->materno);
        $this->tipo_documento = $persona->tipo_documento;
        $this->nro_documento = $persona->nro_documento;
        $this->complemento = $persona->complemento;
        $this->empresa = Str::title($persona->empresa);
        $this->email = $persona->email;
        $this->celular = $persona->celular;
        $this->modalToggle = true;
    }

    public function actualizar(){
        $this->validate();
        $persona = Persona::where('id', $this->persona_id)->update([
            'nombre' => mb_strtolower($this->nombre),
            'paterno' => mb_strtolower($this->paterno),
            'materno' => mb_strtolower($this->materno),
            'tipo_documento' => $this->tipo_documento,
            'nro_documento' => $this->nro_documento,
            'complemento' => $this->complemento,
            'empresa' => mb_strtolower($this->empresa),
            'email' => $this->email,
            'celular' => $this->celular,
        ]);

        if($persona){
            $this->resetValidation();
            $this->resetInputs();
            $this->cerrarModal();
            $this->emit('successMessage', 'actualizar');
        }else{
            $this->emit('exito', 'Ocurrio un error al crear el recurso intentelo nuevamente');
        }
    }

    public function actualizarEstado(Persona $persona){
        $persona->estado = !$persona->estado;
        $persona->save();
    }

    public function eliminarProveedor(Persona $persona){
        $compras = Compra::where('proveedor_id', $persona->id)->get();

        if(count($compras) === 0){
            $persona->delete();
            $this->emit('successMessage', 'eliminar');
        }else{
            $this->emit('existe', 'No puedes eliminar este proveedor porque ya tiene compras vinculadas');
        }
    }
}
