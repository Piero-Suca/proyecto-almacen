<?php

namespace App\Livewire\Admin;

use App\Models\Articulos;
use Livewire\Component;

class ArticuloIndex extends Component
{
    public function render()
    {
        $articulo = Articulos::all();
        return view('livewire.admin.articulo-index', compact('articulo'));
    }
}
