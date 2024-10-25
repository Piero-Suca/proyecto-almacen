<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salidas extends Model
{
    use HasFactory;

    protected $fillable = [
        'persona_dni',
        'articulo_id',
        'cantidad',
        'condicion',
        'fecha_salida',
        'destino',
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulos::class, 'articulo_id');
    }

    public function persona()
    {
        return $this->belongsTo(Personas::class, 'persona_dni');
    }
}
