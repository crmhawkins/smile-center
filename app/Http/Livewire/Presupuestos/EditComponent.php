<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\Cliente;
use App\Models\Evento;
use App\Models\Articulos;
use App\Models\Aseguradora;
use App\Models\TipoEvento;
use App\Models\CategoriaEvento;
use App\Models\ServicioEvento;
use App\Models\ServicioPresupuesto;
use App\Models\PackPresupuesto;
use App\Models\Monitor;
use App\Models\Presupuesto;
use App\Models\Contrato;
use App\Models\EstadoPresupuesto;
use App\Models\Paciente;
use App\Models\Programa;
use App\Models\Servicio;
use App\Models\ServicioPack;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditComponent extends Component
{
    use LivewireAlert;
    public $identificador;
    public $paciente_id;
    public $pacientes;
    public $aseguradora_id;
    public $aseguradoras;
    public $estado_id;
    public $observacion;
    public $servicios;
    public $fechaEmision;
    public $estados;
    public $listaServicios;
    public $servicio_seleccionado;
    public $ServiciosDelete = [];



    public function mount()
    {

        $presupuesto = Presupuesto::find($this->identificador);
        $this->pacientes = Paciente::all();
        $this->estados = EstadoPresupuesto::all();
        $this->servicios = Servicio::all();
        $this->aseguradoras = Aseguradora::all();
        $this->paciente_id = $presupuesto->paciente_id;
        $this->aseguradora_id = $presupuesto->aseguradora_id;
        $this->estado_id = $presupuesto->estado_id;
        $this->observacion = $presupuesto->observacion;
        $this->fechaEmision = $presupuesto->fechaEmision;
        $this->listaServicios = $presupuesto->servicios()->get()->toArray();


    }

    public function render()
    {
        return view('livewire.presupuestos.edit-component');
    }

    public function addServicio(){
        if(!isset($this->servicio_seleccionado)){
            return;
        }
        $servicio = Servicio::find($this->servicio_seleccionado);
        $this->listaServicios[] = [
            'nombre' => $servicio->nombre,
            'descripcion' => $servicio->descripcion,
            'precio' => $servicio->precio,
            'iva' => $servicio->iva ?? null,
        ];
        $servicio= null;
        $this->servicio_seleccionado = null;
        $this->emit('resetSelect2');
    }

    public function deleteServicio($key)
    {   //Miro si existe en la bd y si es asi lo borro
        if (isset($this->listaServicios[$key]["id"])) {
            //Lo añado de la lista de eliminados
            $this->ServiciosDelete[] = $this->listaServicios[$key]['id'];
        }
        //Lo quito de la lista de servicios
        unset($this->listaServicios[$key]);
        // Reindexa el arreglo después de eliminar un elemento
        $this->listaServicios = array_values($this->listaServicios);

    }

    // Al hacer submit en el formulario
    public function update()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        $validatedData = $this->validate(
            [
                'paciente_id' => 'required',
                'aseguradora_id' => 'nullable',
                'observacion' => 'nullable',
                'fechaEmision' => 'required',
                'estado_id' => 'required',

            ],
            // Mensajes de error
            [
                'fechaEmision.required' => 'La Fecha es obligatoria.',
                'estado_id.required' => 'El Estado es es obligatorio.',
                'paciente_id.required' => 'El Paciente es obligatorio.',
            ]
        );

        // Guardar datos validados
        $presupuesosSave = $presupuesto->update($validatedData);
        event(new \App\Events\LogEvent(Auth::user(), 6, $presupuesto->id));

        foreach ($this->ServiciosDelete as $servicio) {
            $presupuesto->servicios()->where('id',$servicio)->delete();
        }

        foreach ($this->listaServicios as $servicio) {
            // Verificar si el servicio ya tiene un ID asignado
            if (empty($servicio['id'])) {
                // Si no tiene ID, entonces se crea el servicio en el presupuesto
                $presupuesto->servicios()->create($servicio);
            }
        }

        // Alertas de guardado exitoso
        if ($presupuesosSave) {
            $this->alert('success', '¡Presupuesto actualizado correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido actualizar la información del presupuesto!', [
                'position' => 'center',
                'toast' => false,
            ]);
        }
    }


    public function destroy()
    {
        $presupuesto = Presupuesto::find($this->identificador);

        $presupuesto->servicios()->delete();
        // Guardar datos validados
        $presupuesosSave = $presupuesto->delete();

        // Alertas de guardado exitoso
        if ($presupuesosSave) {
            $this->alert('success', '¡Presupuesto eliminado correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido actualizar la información del presupuesto!', [
                'position' => 'center',
                'toast' => false,
            ]);
        }
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'destroy',
            'confirmed',
            'imprimirPresupuesto',
            'update',
            'cita',
        ];
    }


    public function confirmed()
    {
        return redirect()->route('presupuestos.index');
    }
    public function cita()
    {
        return redirect()->route('citas.create',['id'=> $this->identificador]);
    }

    public function alertaImprimir()
    {
        $this->alert('info', '¿Desea descargar el presupuesto en PDF?', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'imprimirPresupuesto',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }
    public function alertaGuardar()
    {
        $this->alert('info', '¿Desea actualizar los datos el presupuesto?', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'update',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }

    public function alertaEliminar()
    {
        $this->alert('error', '¿Seguro que desea eliminar el presupuesto? No se puede revertir este proceso.', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'destroy',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
            'timer' => null
        ]);
    }
    public function crearCita()
    {
        $this->alert('info', '¿Desea generar una cita a partir del presupuesto?', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'cita',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
            'timer' => null
        ]);
    }

    public function imprimirPresupuesto()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        $listaServicios = [];
        $listaPacks = [];

        foreach ($presupuesto->servicios()->get() as $servicio) {
            $listaServicios[] = [
                'id' => $servicio->id,
                'numero_monitores' => $servicio->pivot->numero_monitores,
                'precioFinal' => $servicio->pivot->precio_final,
                'tiempo' => $servicio->pivot->tiempo,
                'hora_inicio' => $servicio->pivot->hora_inicio,
                'hora_finalizacion' => $servicio->pivot->hora_finalizacion,
                'existente' => 1,
                'concepto' => $servicio->pivot->concepto,
                'visible' => $servicio->pivot->visible ];
        }

        foreach ($presupuesto->packs()->get() as $pack) {
            $listaPacks[] = ['id' => $pack->id, 'numero_monitores' => json_decode($pack->pivot->numero_monitores, true), 'precioFinal' => $pack->pivot->precio_final, 'existente' => 1];
        }


        $datos =  [
            'presupuesto' => $presupuesto,  'id_presupuesto' => $presupuesto->id, 'fechaEmision' => $this->fechaEmision, 'fechaVencimiento' => $this->fechaVencimiento,
            'listaServicios' => $listaServicios, 'listaPacks' => $listaPacks,  'observaciones' => '', 'servicios' => Servicio::all(),
        ];

        $pdf = Pdf::loadView('livewire.presupuestos.contract-component', $datos)->setPaper('a4', 'vertical')->output(); //
        return response()->streamDownload(
            fn () => print($pdf),
            'export_protocol.pdf'
        );
    }


}
