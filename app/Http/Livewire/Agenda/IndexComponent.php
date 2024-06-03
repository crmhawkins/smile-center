<?php

namespace App\Http\Livewire\Agenda;

use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\Cita;
use App\Models\Paciente;
use Livewire\Component;
use Carbon\Carbon;

class IndexComponent extends Component
{
    use LivewireAlert;
    public $citas;
    public $dias = [];
    public $semana;
    public $pacientes;
    public $fechas = [];


    protected $listeners = [
        'loadWeek' => 'loadWeek',
        'loadMonth' => 'loadMonth',
        'refreshComponent' => '$refresh',
        'confirmed' => 'recargarPagina'
    ];


    public function mount()
    {
        $this->citas = Cita::all();
        $this->pacientes = Paciente::all();
        $this->semana = Carbon::now()->year . "-W" . Carbon::now()->weekOfYear;
        $this->cambioSemana();
    }


    public function render()
    {
        return view('livewire.agenda.index-component');
    }

    public function cambioSemana()
    {
        $this->fechas = [];
        $this->dias = [];

        list($year, $week) = explode('-W', $this->semana);

        $fechaInicio = Carbon::now()->setISODate($year, $week, 1); // El 1 al final establece el día de inicio de la semana a lunes
        for ($i = 0; $i < 7; $i++) {
            $this->fechas[] = $fechaInicio->copy()->addDays($i)->toDateString();
        }


        foreach ($this->fechas as $diaIndex => $dia) {
            $date = Carbon::parse($dia);
            $formattedDate = $date->isoFormat('dddd, D [de] MMMM [de] Y');
            $this->dias[$diaIndex] = str_replace('s畸bado', 'sábado', $formattedDate);  // lunes, 21 de agosto de 2023
        }

        $this->emit('refreshComponent');
    }
    public function getNombre($id){
        $paciente = $this->pacientes->find($id);
        if(isset($paciente)){
            $nombre = $paciente->nombre.' '.$paciente->apellido;
        }else{
            $nombre = 'Paciente no encontrado';
        }
        return $nombre;
    }

}
