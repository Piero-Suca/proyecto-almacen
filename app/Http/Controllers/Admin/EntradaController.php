<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Articulos;
use App\Models\Entradas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function search(Request $request)
        {
            $query = $request->input('search');
            $descripciones = Articulo::where('descripcion', 'like', "%$query%")
                ->pluck('descripcion');

            return response()->json($descripciones);
        }
    
    public function index()
    {
        return view('admin.entrada.index');
    }

    public function pdf()
    {
        $entradas = Entradas::all();
        $pdf = Pdf::loadView('admin.entrada.pdf', compact('entradas'));
        return $pdf->stream();
    }



    public function filterByEntradas(Request $request)
    {
        $fecha_salida = $request->input('fecha_salida');
        $fecha_retorno = $request->input('fecha_retorno');

        $entradas = Entradas::whereBetween('fecha_entrada', [$fecha_salida, $fecha_retorno])->with(['articulo'])->get();

        if ($entradas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron elementos en el rango de fechas proporcionado.']);
        }

        return response()->json($entradas);
    }

    public function generatePDF(Request $request)
    {
        $fecha_salida = $request->input('fecha_salida');
        $fecha_retorno = $request->input('fecha_retorno');
    
        $data = Entradas::whereBetween('fecha_entrada', [$fecha_salida, $fecha_retorno])->get();
    
        $pdf = PDF::loadView('reporteentrada', compact('data'));
    
        // Devolver la vista del PDF como una respuesta HTTP
        return $pdf->stream('reporteentrada.pdf');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validateData = $request->validate([
            'articulo_id' => 'required|exists:articulos,id',
            'cantidad' => 'required',
            'fecha_entrada' => 'required',
            'descripcion' => 'nullable',

        ]);

        $entrada = new Entradas();
        $entrada ->articulo_id = $validateData['articulo_id'];
        $entrada ->cantidad = $validateData['cantidad'];
        $entrada ->fecha_entrada = $validateData['fecha_entrada'];
        $entrada ->descripcion = $validateData['descripcion'];

        $entrada->save();

        if ($entrada) {
            $articulo = Articulos::findOrFail($validateData['articulo_id']);
            $articulo->stock += $validateData['cantidad'];
            $articulo->save();

            return redirect()->route('admin.entrada.index')->with('success', 'La entrada fue registrada correctamente y el stock del artículo se actualizó.');
        } else {
            return redirect()->back()->withErrors('No se registró correctamente la entrada.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'articulo_id' => 'required|exists:articulos,id',
            'cantidad' => 'required',
            'fecha_entrada' => 'required',
            'descripcion' => 'nullable',
        ]);

        $entrada = Entradas::findOrFail($id);
        $entrada->articulo_id = $validateData['articulo_id'];
        $entrada->cantidad = $validateData['cantidad'];
        $entrada->fecha_entrada = $validateData['fecha_entrada'];
        $entrada ->descripcion = $validateData['descripcion'];

        $entrada->save();

        $articulo = Articulos::findOrFail($validateData['articulo_id']);
        $articulo->stock += $validateData['cantidad'];
        $articulo->save();


        if ($entrada){
            return redirect()->route('admin.entrada.index')->with('success', 'La entrada fue actualizada correctamente.');
        }else {
            return redirect()->back()->withErrors('No se actualizo correctamente la entrada.'. $entrada->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Entradas::find($id)->delete();
        return redirect()->route('admin.entrada.index')->with('success', 'La entrada fue eliminada correctamente.');
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
