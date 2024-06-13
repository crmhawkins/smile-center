<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\EstadoPresupuesto;
use App\Models\Paciente;
use App\Models\Presupuesto;
use Livewire\Component;
use Carbon\Carbon;

class TrelloComponent extends Component
{
    public $presupuestosPorEstado;
    public $pacientes;
    public $estados;
    public $fechaInicio;
    public $fechaFin;

    protected $listeners = ['actualizarEstado'];

    public function mount()
    {
        $this->pacientes = Paciente::all();
        $this->estados = EstadoPresupuesto::all();
        $this->fechaInicio = Carbon::now()->subMonths(3)->format('Y-m-d');
        $this->fechaFin = Carbon::now()->addDay(1)->format('Y-m-d');
        $this->presupuestosPorEstado = $this->presupuestosAgrupadosPorEstado();
    }

    public function presupuestosAgrupadosPorEstado()
    {
        $presupuestos = Presupuesto::whereBetween('created_at', [$this->fechaInicio, $this->fechaFin])
                                    ->get()
                                    ->groupBy('estado_id');
        $totales = [];

        foreach ($presupuestos as $estadoId => $presupuestosPorEstado) {
            $total = $presupuestosPorEstado->sum(function($presupuesto) {
                return $presupuesto->total ?? $presupuesto->servicios()->sum('precio');
            });
            $totales[$estadoId] = $total;
        }

        return ['presupuestos' => $presupuestos, 'totales' => $totales];
    }

    public function actualizarEstado($presupuestoId, $nuevoEstadoId)
    {
        $presupuesto = Presupuesto::find($presupuestoId);
        $presupuesto->estado_id = $nuevoEstadoId;
        $presupuesto->save();
        $this->presupuestosPorEstado = $this->presupuestosAgrupadosPorEstado();
    }

    public function getClienteNombre($id)
    {
        if ($id == 0) {
            return "Presupuesto sin cliente";
        }
        $paciente = $this->pacientes->find($id);

        $nombre = $paciente->nombre;
        $apellido = $paciente->apellido;

        return "$nombre $apellido";
    }

    public function getTotal($presupuesto)
    {
        if ($presupuesto->total) {
            return $presupuesto->total . ' €';
        } else {
            $total = $presupuesto->servicios()->sum('precio');
            return $total . ' €';
        }
    }

    public function updatedFechaInicio()
    {
        $this->presupuestosPorEstado = $this->presupuestosAgrupadosPorEstado();
    }

    public function updatedFechaFin()
    {
        $this->presupuestosPorEstado = $this->presupuestosAgrupadosPorEstado();
    }

    public function render()
    {
        return view('livewire.presupuestos.trello-component', [
            'presupuestosPorEstado' => $this->presupuestosPorEstado,
            'estados' => $this->estados
        ]);
    }
}
