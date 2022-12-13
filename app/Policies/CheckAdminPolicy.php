<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CheckAdminPolicy
{
    use HandlesAuthorization;

    public function checkAdmin(User $user)
    {
        $role = $user->role->nombre;

        return $role === 'administrador' ? Response::allow() : Response::deny('No puedes acceder si no tienes rol administrador');
    }
}
