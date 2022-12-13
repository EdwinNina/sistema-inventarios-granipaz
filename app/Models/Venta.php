<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['codigo','tipo_comprobante', 'nro_comprobante', 'cantidad', 'total', 'fecha', 'cliente_id', 'estado', 'user_id'];
}
