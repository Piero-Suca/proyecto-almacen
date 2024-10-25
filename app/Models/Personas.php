<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;
    protected $table = 'personas';
    protected $primaryKey = 'dni';
    public $incrementing = false; // Si dni no es un entero autoincremental
    protected $keyType = 'string'; // Si dni es de tipo string

    protected $fillable = [
        'dni',
        'nombres',
        'apellidos',
        'nro_celular',
        'tipo_persona'
    ];
}
