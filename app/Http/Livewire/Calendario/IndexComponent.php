<?php

namespace App\Http\Livewire\Calendario;

use App\Models\Evento;
use App\Models\Presupuesto;
use Livewire\Component;

class IndexComponent extends Component
{
    public $eventos;
    public $presupuestos;

    public function mount()
    {
        $this->eventos = Evento::all();
        $this->presupuestos = Presupuesto::all();
    }
    public function render()
    {
        return view('livewire.calendario.index-component');
    }
}
