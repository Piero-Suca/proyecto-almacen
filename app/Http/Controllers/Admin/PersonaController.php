<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PersonasImport;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.persona.index');
    }


    public function render()
    {
        $personas = Personas::with('direccion')->paginate(10);
        return view('livewire.personas', compact('personas'));
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        $results = Personas::where('nombres', 'LIKE', '%' . $term . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $term . '%')
                    ->select('id', 'nombres', 'apellidos')
                    ->get();

        return response()->json($results);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'dni' => 'required|numeric|unique:personas,dni',  // Validación para DNI único y numérico
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'nro_celular' => 'nullable|numeric',  // Validación opcional, si está presente debe ser numérico
            'tipo_persona' => 'required|string|max:255',
        ]);
    
        $persona = new Personas();
        $persona->dni = $validateData['dni'];
        $persona->nombres = $validateData['nombres'];
        $persona->apellidos = $validateData['apellidos'];
        $persona->nro_celular = $validateData['nro_celular'];
        $persona->tipo_persona = $validateData['tipo_persona'];
    
        try {
            $persona->save();
            return redirect()->route('admin.persona.index')->with('success', 'La persona fue registrada correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == '23000'){ // Código de error para violación de restricción de integridad
                return redirect()->back()->withErrors('Ya existe una persona con ese DNI.')->withInput();
            }
            return redirect()->back()->withErrors('Ocurrió un error al registrar la persona.')->withInput();
        }
    }
    

    public function update(Request $request, string $dni)
    {
        $validateData = $request->validate([
            'dni' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'nro_celular' => '',
            'tipo_persona' => 'required',
        ]);

        $persona =Personas::findOrFail($dni);
        $persona->dni = $validateData['dni'];
        $persona->nombres = $validateData['nombres'];
        $persona->apellidos = $validateData['apellidos'];
        $persona->nro_celular = $validateData['nro_celular'];
        $persona->tipo_persona = $validateData['tipo_persona'];

        $persona->save();

        if ($persona){
            return redirect()->route('admin.persona.index')->with('success', 'La persona fue actualizada correctamente.');
        }else {
            return redirect()->back()->withErrors('No se actualizo correctamente la persona.'. $persona->getMessage());
        }
    }

    public function import(Request $request)
    {
        // Validar que el archivo esté presente y sea de tipo Excel
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);
    
        // Procesar el archivo y usar la clase importadora
        $import = new PersonasImport();
        Excel::import($import, $request->file('file'));
    
        // Obtener los DNIs duplicados
        $duplicados = $import->getDuplicates();
    
        // Verificar si hay duplicados y redirigir con un mensaje de error
        if (!empty($duplicados)) {
            return redirect()->back()->withErrors('Los siguientes DNI ya existen: ' . implode(', ', $duplicados));
        }
    
        // Redirigir con un mensaje de éxito si no hay duplicados
        return redirect()->back()->with('success', 'Personas importadas correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Personas::find($id)->delete();
        return redirect()->route('admin.persona.index')->with('success', 'La persona fue eliminado correctamente.');
        
    }
}
