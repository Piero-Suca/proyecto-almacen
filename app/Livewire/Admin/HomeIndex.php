<?php

namespace App\Livewire\Admin;

use App\Models\Articulos;
use App\Models\Entradas;
use App\Models\Personas;
use App\Models\Salidas;
use Livewire\Component;

class HomeIndex extends Component
{
    public function render()
    {
        //LAMADOS APRA EL DASHBOARD
        $personas=Personas::count();
        $salidas=Salidas::count();
        $entradas=Entradas::count();
        
        $picos = Articulos::where('nombre_articulo', 'PICOS')->value('stock');
        $pala = Articulos::where('nombre_articulo', 'PALA')->value('stock');
        $combo = Articulos::where('nombre_articulo', 'COMBO DE 8 LIBRAS')->value('stock');
        $segadera = Articulos::where('nombre_articulo', 'SEGADERA')->value('stock');
        $tijeradepodar = Articulos::where('nombre_articulo', 'TIJERA DE PODAR GRANDE')->value('stock');
        $machete = Articulos::where('nombre_articulo', 'MACHETE')->value('stock');
        $rastrillo = Articulos::where('nombre_articulo', 'RASTRILLO TIPO ABANICO')->value('stock');
        $extintor = Articulos::where('nombre_articulo', 'EXTINTOR EFELSA 2KL')->value('stock');


        return view('livewire.admin.home-index',compact('picos','pala','combo','segadera','tijeradepodar','machete','rastrillo','extintor'));
    }
}
