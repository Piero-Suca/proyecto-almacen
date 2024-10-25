<?php

namespace App\Imports;

use App\Models\Personas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PersonasImport implements ToModel, WithHeadingRow
{
    protected $duplicates = []; // Array para guardar DNIs duplicados

    public function model(array $row)
    {
        // Verificar si la persona ya existe
        $personaExistente = Personas::where('dni', $row['dni'])->first();

        if (!$personaExistente) {
            // Si no existe, se crea una nueva persona
            return new Personas([
                'dni' => $row['dni'],
                'nombres' => $row['nombres'],
                'apellidos' => $row['apellidos'],
                'nro_celular' => $row['nro_celular'],
                'tipo_persona' => $row['tipo_persona'],
            ]);
        } else {
            // Si ya existe, almacenar el DNI duplicado
            $this->duplicates[] = $row['dni'];
            return null; // No intentamos volver a insertar
        }
    }
    public function getDuplicates()
    {
        return $this->duplicates; // Método para acceder a los DNIs duplicados
    }
}