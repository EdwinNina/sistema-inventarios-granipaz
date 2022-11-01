<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'tipo_documento',
        'nro_documento',
        'complemento',
        'empresa',
        'email',
        'celular',
        'tipo_persona',
        'estado'
    ];

    public function getNombreCompletoAttribute(){
        return Str::ucfirst($this->paterno) . ' ' . Str::ucfirst($this->materno) . ' ' . Str::title($this->nombre);
    }
}
