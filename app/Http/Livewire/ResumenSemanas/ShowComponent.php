<?php

namespace App\Http\Livewire\ResumenSemanas;

use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\Programa;
use App\Models\Evento;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Monitor;
use App\Models\Presupuesto;
use App\Models\Servicio;
use App\Models\ServicioEvento;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ShowComponent extends Component
{
    use LivewireAlert;
    // public $search;
    public $dias = [];
    public $semana;
    public $monitores_datos;
    public $fechas = [];
    public $presupuestos;
    public $eventos;

    protected $listeners = [
        'loadWeek' => 'loadWeek',
        'loadMonth' => 'loadMonth',
    ];


    public function mount()
    {
        $this->presupuestos = Presupuesto::all();
        $this->monitores_datos = Monitor::all();
    }


    public function render()
    {

        return view('livewire.resumen-semana.show-component');
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
        $this->eventos = Evento::whereBetween('diaEvento', [$this->fechas[0], $this->fechas[6]])->get();

        foreach ($this->fechas as $diaIndex => $dia) {
            $date = Carbon::parse($dia);
            $formattedDate = $date->isoFormat('dddd, D [de] MMMM [de] Y');
            $this->dias[$diaIndex] = str_replace('s畸bado', 'sábado', $formattedDate);  // lunes, 21 de agosto de 2023
        }
    }
}
