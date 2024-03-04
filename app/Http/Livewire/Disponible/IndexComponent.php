<?php

namespace App\Http\Livewire\Disponible;

use App\Models\Presupuesto;
use App\Models\Servicio;
use App\Models\Articulos;
use Livewire\Component;

class IndexComponent extends Component
{
    public $servicios;
    public $articulos;


    public function mount()
    {
        $this->servicios = Servicio::all();
        $this->articulos = Articulos::all();
    }



    public function render()
    {
        return view('livewire.disponible.index-component');
    }
}
