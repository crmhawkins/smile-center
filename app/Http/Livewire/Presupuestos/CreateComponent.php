<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\Paciente;
use App\Models\Aseguradora;
use App\Models\EstadoPresupuesto;
use App\Models\Presupuesto;
use App\Models\Servicio;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


use function PHPUnit\Framework\isEmpty;

class CreateComponent extends Component
{

    use LivewireAlert;
    public $identificador;
    public $paciente_id;
    public $pacientes;
    public $aseguradora_id;
    public $aseguradoras;
    public $estado_id = 1;
    public $observacion;
    public $servicios;
    public $fechaEmision;
    public $estados;
    public $listaServicios = [];
    public $servicio_seleccionado;

    public function mount()
    {
        $this->fechaEmision = Carbon::now()->format('Y-m-d');
        $this->pacientes = Paciente::all();
        $this->estados = EstadoPresupuesto::all();
        $this->servicios = Servicio::all();
        $this->aseguradoras = Aseguradora::all();

    }
    public function render()
    {
        return view('livewire.presupuestos.create-component');
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
    public function deleteServicio($indice)
    {
        unset($this->listaServicios[$indice]);
        $this->listaServicios = array_values($this->listaServicios);
    }
    // Al hacer submit en el formulario
    public function submit()
    {
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
        $presupuesosSave = Presupuesto::create($validatedData);
        $this->identificador = $presupuesosSave->id;

        event(new \App\Events\LogEvent(Auth::user(), 3, $presupuesosSave->id));

        foreach ($this->listaServicios as $servicio) {
            $presupuesosSave->servicios()->create($servicio);
        }

        // Alertas de guardado exitoso
        if ($presupuesosSave) {
            $this->alert('success', '¡Presupuesto registrado correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Seguir editando',
                'showDenyButton' => true,
                'denyButtonText' => 'Ver contrato',
                'onDenied' => 'verContrato',
                'timer' => null,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del presupuesto!', [
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
            'alertaGuardar',
            'submit'

        ];
    }

    public function alertaGuardar()
    {
        $this->alert('warning', 'Asegúrese de que todos los datos son correctos antes de guardar.', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'submit',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('presupuestos.edit', $this->identificador);
    }

}
