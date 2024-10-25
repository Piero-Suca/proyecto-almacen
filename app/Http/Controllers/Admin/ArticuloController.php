<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Articulos;
use App\Models\creacions;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('admin.articulo.index');
    }

     //crear metodo pdf
    public function pdf()
    {
        $articulos = Articulos::all();
        $pdf = Pdf::loadView('admin.articulo.pdf', compact('articulos'));
        return $pdf->stream();
    }


    public function filterByArticulos(Request $request)
    {
        $fecha_salida = $request->input('fecha_salida');
        $fecha_retorno = $request->input('fecha_retorno');
    
        // Asegúrate de que las fechas estén en el formato correcto (ej. 'Y-m-d')
        $articulos = Articulos::whereBetween('fecha_creacion', [$fecha_salida, $fecha_retorno])->get();
    
        if ($articulos->isEmpty()) {
            return response()->json(['message' => 'No se encontraron elementos en el rango de fechas proporcionado.']);
        }
    
        return response()->json($articulos);
    }

    public function generatePDF(Request $request)
    {
        $fecha_salida = $request->input('fecha_salida');
        $fecha_retorno = $request->input('fecha_retorno');
    
        $data = Articulos::whereBetween('fecha_creacion', [$fecha_salida, $fecha_retorno])->get();
    
        $pdf = PDF::loadView('reportearticulo', compact('data'));
    
        // Devolver la vista del PDF como una respuesta HTTP
        return $pdf->stream('reportearticulo.pdf');
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
        $validatedData = $request->validate([
            'nombre_articulo' => 'required',
            'marca' => '',
            'descripcion' => 'required',
            'stock' => 'required',
            'estado' => 'required',
            'fecha_creacion' => 'required',
        ]);
    
        // Crear una nueva instancia del modelo Articulo y asignar los valores
        $articulo = new Articulos();
        $articulo->nombre_articulo = $validatedData['nombre_articulo'];
        $articulo->marca = $validatedData['marca'];
        $articulo->descripcion = $validatedData['descripcion'];
        $articulo->stock = $validatedData['stock'];
        $articulo->estado = $validatedData['estado'];
        $articulo->fecha_creacion = $validatedData['fecha_creacion'];
    
        // Guardar el articulo en la base de datos
        $articulo->save();
    
        if ($articulo) {
            return redirect()->route('admin.articulo.index')->with('success', 'El artículo fue registrado correctamente.');
        } else {
            return redirect()->back()->withErrors('No se registró correctamente el artículo.');
        }
    }



    public function devoluciones(string $id)
    {
        // Encontrar la creacion por su ID
        $creacion = creacions::find($id);
        if (!$creacion) {
            return redirect()->route('admin.creacion.index')->withErrors('La creacion no fue encontrada.');
        }
        
        // Encontrar el artículo asociado
        $articulo = Articulos::findOrFail($creacion->articulo_id);
    
        // Incrementar el stock del artículo
        $articulo->stock += $creacion->cantidad;
        $articulo->save();
    
        // Marcar la creacion como devuelta
        $creacion->devuelto = true;
        $creacion->save();
    
        return redirect()->route('admin.creacion.index')->with('success', 'Artículo devuelto correctamente y el stock del artículo se actualizó.');
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
            'nombre_articulo' => 'required',
            'marca' => '',
            'descripcion' => 'required',
            'stock' => 'required',
            'estado' => 'required',
            'fecha_creacion' => 'required',
        ]);

        $articulo =Articulos::findOrFail($id);
        $articulo->nombre_articulo = $validateData['nombre_articulo'];
        $articulo->marca = $validateData['marca'];
        $articulo->descripcion = $validateData['descripcion'];
        $articulo->stock = $validateData['stock'];
        $articulo->estado = $validateData['estado'];
        $articulo->fecha_creacion = $validateData['fecha_creacion'];

        $articulo->save();

        if ($articulo){
            return redirect()->route('admin.articulo.index')->with('success', 'El articulo fue actualizada correctamente.');
        }else {
            return redirect()->back()->withErrors('No se actualizo correctamente el articulo.'. $articulo->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            Articulos::find($id)->delete();
            return redirect()->route('admin.articulo.index')->with('success', 'El artículo fue eliminado correctamente.');
        }
    }
}
