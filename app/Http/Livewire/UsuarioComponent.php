<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\Role;
use App\Models\User;
use App\Models\Venta;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class UsuarioComponent extends Component
{
    use WithPagination;

    public $modalToggle = false;
    public $name = '', $email = '', $password = '', $usuario_id = '', $role_id = '';

    public function render()
    {
        $usuarios = User::with('role')->paginate(5);
        $roles = Role::where('estado', 1)->get();

        return view('livewire.usuario-component', compact('usuarios', 'roles'));
    }

    private function resetInputs()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role_id = '';
    }

    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email',
            'password' => 'required',
            'role_id' => 'required',
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
        User::create([
            'name' => mb_strtolower($this->name),
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role_id' => $this->role_id
        ]);
        $this->resetInputs();
        $this->cerrarModal();
        $this->emit('successMessage', 'crear');
    }

    public function editar(User $usuario)
    {
        $this->usuario_id = $usuario->id;
        $this->name = Str::title($usuario->name);
        $this->email = $usuario->email;
        $this->password = $usuario->password;
        $this->role_id = $usuario->role_id;
        $this->modalToggle = true;
    }

    public function actualizar()
    {
        $usuario = User::find($this->usuario_id);
        $usuario->name = mb_strtolower($this->name);
        $usuario->email = $this->email;
        $usuario->password = bcrypt($this->password);
        $usuario->role_id = $this->role_id;

        $usuario->save();
        $this->resetValidation();
        $this->cerrarModal();
        $this->emit('successMessage', 'actualizar');
    }

    public function actualizarEstado(User $usuario)
    {
        $usuario->estado = !$usuario->estado;
        $usuario->save();
    }

    public function eliminar(User $usuario)
    {
        $compras = Compra::where('user_id', $usuario->id)->get();
        $ventas = Venta::where('user_id', $usuario->id)->get();

        if (count($compras) === 0 || count($ventas) === 0) {
            $usuario->delete();
            $this->emit('successMessage', 'eliminar');
        }else {
            $this->emit('existe', 'No puedes eliminar este usuario porque tiene compras y/o ventas realizados');
        }
    }
}
