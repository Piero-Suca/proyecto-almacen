<?php

namespace App\Livewire\Admin;

use App\Models\Articulos;
use App\Models\Entradas;
use Livewire\Component;

class EntradaIndex extends Component
{
    public function render()
    {
        // $productos = Product::all();
        $entradas = Entradas::with('articulo')->get();
        $articulos = Articulos::all();
        return view('livewire.admin.entrada-index', compact('entradas', 'articulos'));
    }
}