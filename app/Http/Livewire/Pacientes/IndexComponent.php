<?php

namespace App\Http\Livewire\Pacientes;

use App\Models\Paciente;
use Livewire\Component;

class IndexComponent extends Component
{
    // public $search;
    public $pacientes;

    public function mount()
    {
        $this->pacientes = Paciente::where('estado_id',3)->get();
    }

    public function render()
    {

        return view('livewire.pacientes.index-component');
    }

}
