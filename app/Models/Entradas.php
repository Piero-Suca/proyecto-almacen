<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entradas extends Model
{
    use HasFactory;

    protected $fillable = [
        'articulo_id',
        'cantidad',
        'fecha_entrada',
        'descripcion',
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulos::class, 'articulo_id');
    }
}
