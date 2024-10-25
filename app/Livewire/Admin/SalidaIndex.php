<?php

namespace App\Livewire\Admin;

use App\Models\Articulos;
use App\Models\Personas;
use App\Models\Salidas;
use Livewire\Component;

class SalidaIndex extends Component
{
    public function render()
    {
        // $productos = Product::all();
        $salidas = Salidas::with('articulo')->get();
        $articulos = Articulos::all();
        $personas = Personas::all();
        return view('livewire.admin.salida-index', compact('salidas', 'articulos','personas'));
    }


}