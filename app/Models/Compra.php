<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = ['codigo','tipo_comprobante', 'nro_comprobante', 'cantidad', 'total', 'fecha', 'proveedor_id'];
}
