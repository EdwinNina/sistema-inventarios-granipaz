<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $fillable = ['cantidad', 'subtotal', 'compra_id', 'producto_id', 'precio_compra'];
}
