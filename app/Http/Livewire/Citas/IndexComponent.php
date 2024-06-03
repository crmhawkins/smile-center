<?php

namespace App\Http\Livewire\Citas;

use App\Models\Cita;
use App\Models\Paciente;
use Livewire\Component;

class IndexComponent extends Component
{
    public $citas;

    public function mount()
    {
        $this->citas = Cita::all();

    }
    public function getNombre($id){
        $paciente = Paciente::find($id);
        if(isset($paciente)){
            $nombre = $paciente->nombre.' '.$paciente->apellido;
        }else{
            $nombre = 'Paciente no encontrado';
        }
        return $nombre;
    }
    public function render()
    {
        return view('livewire.citas.index-component');
    }
}
