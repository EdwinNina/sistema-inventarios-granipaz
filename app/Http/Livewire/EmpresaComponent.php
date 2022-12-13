<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Empresa;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EmpresaComponent extends Component
{
    use WithFileUploads;

    public $empresa, $nit, $direccion, $logotipo, $paterno, $materno, $nombre, $stock_minimo, $correo, $celular;

    public function mount(){

        Gate::authorize('checkAdminUser', auth()->id());

        $empresa_count = Empresa::count();
        if($empresa_count > 0){
            $empresa = Empresa::first();
            $this->empresa = Str::title($empresa->empresa);
            $this->direccion = Str::title($empresa->direccion);
            $this->nit = $empresa->nit;
            $this->paterno = Str::title($empresa->paterno);
            $this->materno = Str::title($empresa->materno);
            $this->nombre = Str::title($empresa->nombre);
            $this->logotipo = $empresa->logotipo;
            $this->celular = $empresa->celular;
            $this->correo = $empresa->correo;
            $this->stock_minimo = $empresa->stock_minimo;
        }
    }

    public function render()
    {
        return view('livewire.empresa-component');
    }

    public function rules(){
        return [
            'empresa' => 'required',
            'direccion' => 'required',
            'nit' => 'required',
            'correo' => 'required|email',
            'celular' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'nombre' => 'required',
            'logotipo' => 'required|image|max:2048',
            'stock_minimo' => 'required',
        ];
    }

    public function guardar(){
        $this->validate();
        DB::table('empresas')->truncate();
        try {
            Empresa::create([
                'empresa' => mb_strtolower($this->empresa),
                'direccion' => mb_strtolower($this->direccion),
                'nit' => $this->nit,
                'correo' => $this->correo,
                'celular' => $this->celular,
                'paterno' => mb_strtolower($this->paterno),
                'materno' => mb_strtolower($this->materno),
                'nombre' => mb_strtolower($this->nombre),
                'logotipo' => $this->logotipo->store('empresa','public'),
                'stock_minimo' => $this->stock_minimo,
            ]);
            $this->emit('successMessage', 'crear');

        } catch (Exception $ex) {
            $this->emit('existe', $ex['message']);
        }
    }
}
