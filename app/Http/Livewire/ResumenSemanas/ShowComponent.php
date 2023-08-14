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
    public $day;
    public $semanas = [];
    public $programasDia;
    public $clientes;
    public $eventos;
    public $monitores;
    public $i_semana;

    public $selectedEventos = [];

    public $programasEvento;
    public $servicioPrograma;
    public $resumenDia = [];
    public $serviciosEvento;
    public $serviciosPrograma;

    protected $listeners = [
        'loadWeek' => 'loadWeek',
        'loadMonth' => 'loadMonth',
    ];


    public function mount()
    {


        // dd($this->resumenDia);
        //    dd($this->programasDia);
    }

    public function loadMonth()
    {
        $day = Carbon::parse($this->day);
        $daysMonth = $day->daysInMonth;
        $strDay = $this->day;
        $endDayDateStr = substr_replace($strDay, strval($daysMonth), strlen($strDay) - 2, strlen($strDay));
        $firstDayDateStr = substr_replace($strDay, "01", strlen($strDay) - 2, strlen($strDay));
        $endDayDate = Carbon::parse($endDayDateStr);
        $firstDayDate = Carbon::parse($firstDayDateStr);


        $period = CarbonPeriod::create($firstDayDate, $endDayDate);
        $semana = [];
        foreach ($period as $i => $date) {

            $semana[$date->weekNumberInMonth][$date->format("Y-m-d")] = $date;
        }
        $this->semanas = $semana;
    }

    public function loadWeek()
    {
        $day = Carbon::parse($this->day);
        $weekStartDate = $day->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $day->endOfWeek()->format('Y-m-d H:i');
        $period = CarbonPeriod::create($weekStartDate, $weekEndDate);
        $semana = [];
        foreach ($period as $i => $date) {

            $semana[$i] = $date->format("Y-m-d");
        }

        $this->semanas[count($this->semanas)] = $semana;
        // dd($semana);
    }

    public function getTotalMonitores($indice)
    {
        $total = 0;
        // dd($this->resumenDia[$indice]["servicios"]);
        $servicios =  $this->resumenDia[$indice]["servicios"];

        foreach ($servicios as $servicio) {
            foreach ($servicio["programas"] as $programa) {
                $total += $programa["precioMonitor"];
            }
        }


        return $total;
    }
    public function getTotalMonitoresPagado($indice)
    {
        $total = 0;
        // dd($this->resumenDia[$indice]["servicios"]);
        $servicios =  $this->resumenDia[$indice]["servicios"];

        foreach ($servicios as $servicio) {
            foreach ($servicio["programas"] as $programa) {
                $total += $programa["pagado"];
            }
        }


        return $total;
    }
    public function getTotalMonitoresDesplazamiento($indice)
    {
        $total = 0;
        // dd($this->resumenDia[$indice]["servicios"]);
        $servicios =  $this->resumenDia[$indice]["servicios"];

        foreach ($servicios as $servicio) {
            foreach ($servicio["programas"] as $programa) {
                $total += $programa["costoDesplazamiento"];
            }
        }


        return $total;
    }

    public function getGastos($indice)
    {
        $monitores = $this->getTotalMonitores($indice);
        $desplazamiento = $this->getTotalMonitoresDesplazamiento($indice);

        // Todo gastos seguridad social y material

        $total = $monitores + $desplazamiento;
        return $total;
    }

    public function getBalance($indice)
    {
        $gastos = $this->getGastos($indice);
        $ingresos = $this->resumenDia[$indice]["presupuesto"]["precioFinal"];
        $total = $ingresos - $gastos;

        return $total;
    }

    public function render()
    {

        return view('livewire.resumen-semana.show-component');
    }
}
