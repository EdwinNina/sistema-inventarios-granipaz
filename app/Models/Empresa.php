<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['empresa','direccion','nit','paterno','materno','nombre','logotipo', 'stock_minimo','celular', 'correo'];
}
