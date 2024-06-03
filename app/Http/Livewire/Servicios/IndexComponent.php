<?php

namespace App\Http\Livewire\Servicios;

use App\Models\Articulos;
use App\Models\Servicio;
use App\Models\ServicioCategoria;
use App\Models\ServicioPack;
use Livewire\Component;

class IndexComponent extends Component
{
    // public $search;
    public $servicios;
    public $serviciosCategoria;
    public $serviciosPack;

    public function mount()
    {
        $this->servicios = Servicio::all();

    }

    public function render()
    {
        return view('livewire.servicios.index-component');
    }

}
