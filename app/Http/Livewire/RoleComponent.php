<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class RoleComponent extends Component
{
    use WithPagination;

    public $modalToggle = false;
    public $nombre = '', $descripcion = '', $role_id = '';

    public function render()
    {
        $roles = Role::paginate(5);

        return view('livewire.role-component', compact('roles'));
    }

    private function resetInputs()
    {
        $this->nombre = '';
    }

    public function rules()
    {
        return [
            'nombre' => 'required|max:100',
        ];
    }

    public function abrirModal()
    {
        $this->resetInputs();
        $this->resetValidation();
        $this->modalToggle = true;
    }

    public function cerrarModal()
    {
        $this->modalToggle = false;
    }

    public function guardar()
    {
        $this->validate();
        Role::create([
            'nombre' => mb_strtolower($this->nombre),
            'descripcion' => $this->descripcion,
        ]);
        $this->resetInputs();
        $this->cerrarModal();
        $this->emit('successMessage', 'crear');
    }

    public function editar(Role $role)
    {
        $this->role_id = $role->id;
        $this->nombre = Str::title($role->nombre);
        $this->descripcion = $role->descripcion;
        $this->modalToggle = true;
    }

    public function actualizar()
    {
        $role = Role::find($this->role_id);
        $role->nombre = mb_strtolower($this->nombre);
        $role->descripcion = $this->descripcion;
        $role->save();

        $this->resetValidation();
        $this->cerrarModal();
        $this->emit('successMessage', 'actualizar');
    }

    public function actualizarEstado(Role $role)
    {
        $role->estado = !$role->estado;
        $role->save();
    }

    public function eliminar(Role $role)
    {
        $usuarios = User::where('role_id', $role->id)->get();

        if (count($usuarios) === 0) {
            $role->delete();
            $this->emit('successMessage', 'eliminar');
        }else {
            $this->emit('existe', 'No puedes eliminar esta role porque ya esta asignado a usuarios');
        }
    }
}
