<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Articulos;
use App\Models\Personas;
use App\Models\Salidas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.salida.index');
    }


    public function pdf()
    {
        $salidas = Salidas::all();
        $pdf = Pdf::loadView('admin.salida.pdf', compact('salidas'));
        return $pdf->stream();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function filterBySalidas(Request $request)
    {
        $fecha_salida = $request->input('fecha_salida');
        $fecha_retorno = $request->input('fecha_retorno');
    
        $salidas = Salidas::whereBetween('fecha_salida', [$fecha_salida, $fecha_retorno])
            ->with(['articulo', 'persona'])
            ->get();
    
        if ($salidas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron elementos en el rango de fechas proporcionado.']);
        }
    
        return response()->json($salidas);
    }

    
    public function generatePDF(Request $request)
    {
        $fecha_salida = $request->input('fecha_salida');
        $fecha_retorno = $request->input('fecha_retorno');
    
        $data = Salidas::whereBetween('fecha_salida', [$fecha_salida, $fecha_retorno])->get();
    
        $pdf = PDF::loadView('reporte', compact('data'));
    
        // Devolver la vista del PDF como una respuesta HTTP
        return $pdf->stream('reporte.pdf');
    }

    public function getSalidasMensuales()
    {
        $salidas = DB::table('salidas')
            ->select(DB::raw('MONTH(fecha_salida) as mes, SUM(cantidad) as total'))
            ->groupBy('mes')
            ->get();
    
        return response()->json($salidas);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'persona_dni' => 'required',
            'articulo_id' => 'required|exists:articulos,id',
            'cantidad' => 'required|integer|min:1',
            'condicion' => 'required',
            'fecha_salida' => 'required|date',
            'destino' => 'required',
            'fecha_retorno' => 'nullable|date',
        ]);
    
        // Verificar el stock disponible del artículo
        $articulo = Articulos::findOrFail($validateData['articulo_id']);
        if ($articulo->stock < $validateData['cantidad']) {
            return redirect()->back()->with('error', 'Stock insuficiente para la cantidad solicitada.');
        }
    
        // Crear la nueva salida
        $salida = new Salidas();
        $salida->persona_dni = $validateData['persona_dni'];
        $salida->articulo_id = $validateData['articulo_id'];
        $salida->cantidad = $validateData['cantidad'];
        $salida->condicion = $validateData['condicion'];
        $salida->fecha_salida = $validateData['fecha_salida'];
        $salida->destino = $validateData['destino'];
        $salida->fecha_retorno = $validateData['fecha_retorno'] ?? null;
        $salida->save();
    
        // Actualizar el stock del artículo
        $articulo->stock -= $validateData['cantidad'];
        $articulo->save();
    
        if ($salida) {
            return redirect()->route('admin.salida.index')->with('success', 'La salida fue registrada correctamente y el stock del artículo se actualizó.');
        } else {
            return redirect()->back()->with('error', 'No se registró correctamente la salida.');
        }
    }
    
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'persona_dni' => 'required|exists:personas,dni',
            'articulo_id' => 'required|exists:articulos,id',
            'cantidad' => 'required',
            'condicion'=>'required',
            'fecha_salida' => 'required',
            'destino' => 'required',
            'fecha_retorno' => 'nullable|date',
        ]);
    
        $salida = Salidas::findOrFail($id);
        $salida->persona_dni = $validateData['persona_dni'];
        $salida->articulo_id = $validateData['articulo_id'];
        $salida->cantidad = $validateData['cantidad'];
        $salida->condicion = $validateData['condicion'];
        $salida->fecha_salida = $validateData['fecha_salida'];
        $salida->destino = $validateData['destino'];
        $salida->fecha_retorno = $validateData['fecha_retorno'] ?? null;
    
        $salida->save();
    
        // $articulo = Articulos::findOrFail($validateData['articulo_id']);
        // $articulo->stock -= $validateData['cantidad'];
        // $articulo->save();
    
        if ($salida){
            return redirect()->route('admin.salida.index')->with('success', 'La salida fue actualizada correctamente.');
        } else {
            return redirect()->back()->withErrors('No se actualizo correctamente la salida.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $salidas = Salidas::find($id);
    if ($salidas) {
        $salidas->delete();
        return response()->json(['success' => 'Registro eliminado correctamente.']);
    } else {
        return response()->json(['error' => 'Registro no encontrado.'], 404);
    }
}


    public function devoluciones(string $id)
    {
        // Encontrar la salida por su ID
        $salida = Salidas::find($id);
        if (!$salida) {
            return response()->json(['error' => 'La salida no fue encontrada.'], 404);
        }
    
        // Encontrar el artículo asociado
        $articulo = Articulos::findOrFail($salida->articulo_id);
    
        // Incrementar el stock del artículo
        $articulo->stock += $salida->cantidad;
        $articulo->save();
    
        // Marcar la salida como devuelta y actualizar la fecha de retorno
        $salida->devuelto = true;
        $salida->fecha_retorno = now();
        $salida->save();
    
        return response()->json(['success' => 'Artículo devuelto correctamente y el stock del artículo se actualizó.']);
    }

    public function searchArticulos(Request $request)
    {
        $search = $request->input('search');
        $articulos = Articulos::where('nombre_articulo', 'like', '%' . $search . '%')
            ->orWhere('marca', 'like', '%' . $search . '%')
            ->distinct('id') // Asegura que los resultados sean únicos por ID
            ->take(10)
            ->get();
    
        return response()->json($articulos);
    }


}
