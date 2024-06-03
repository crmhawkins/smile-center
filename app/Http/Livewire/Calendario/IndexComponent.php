<?php

namespace App\Http\Livewire\Calendario;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Presupuesto;
use Livewire\Component;

class IndexComponent extends Component
{
    public $citas;
    public $presupuestos;
    public $pacientes;


    public function mount()
    {
        $this->citas = Cita::all();
        $this->presupuestos = Presupuesto::all();
        $this->pacientes = Paciente::all();
    }
    public function render()
    {
        return view('livewire.calendario.index-component');
    }
}
