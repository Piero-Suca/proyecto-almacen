<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulos extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_articulo',
        'marca',
        'descripcion',
        'stock',
        'estado',
        'fecha_creacion'
    ];
}
