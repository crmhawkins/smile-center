<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\EstadoPresupuesto;
use App\Models\Paciente;
use App\Models\Presupuesto;
use Livewire\Component;

class IndexComponent extends Component
{
    // public $search;
    public $presupuestos;
    public $pacientes;
    public $estado;
    public function mount()
    {
        $this->presupuestos = Presupuesto::all();
        $this->pacientes = Paciente::all();
        $this->estado = EstadoPresupuesto::all();
    }

    public function getClienteNombre($id){

        if($id == 0){
            return "Presupuesto sin cliente";
        }
        $paciente = $this->pacientes->find($id);

        $nombre = $paciente->nombre;
        $apellido = $paciente->apellido;

        return "$nombre $apellido";
    }
    public function getEstado($id){

        if($id == 0){
            return "Presupuesto sin estado";
        }
        $estado_presu = $this->estado->find($id);

        return $estado_presu->estado;
    }
    public function getTotal($id){

        $presupuesto = $this->presupuestos->find($id);
        $total = $presupuesto->servicios()->sum('precio');
        return $total.' €';
    }

    public function render()
    {

        return view('livewire.presupuestos.index-component');
    }

}
