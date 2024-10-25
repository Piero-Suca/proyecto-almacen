<?php

namespace App\Livewire\Admin;


use App\Models\Personas;
use Livewire\Component;
use Livewire\WithPagination;

class PersonaIndex extends Component
{
    //  public function render()
    //  {
    //      $persona = Personas::all();

    //      return view('livewire.admin.persona-index', compact('persona'));
    //  }
    use WithPagination;
    public function render()
    {
        $persona = Personas::all();
        return view('livewire.admin.persona-index', [
             'persona' => Personas::paginate(100),
        ]);
     }
}