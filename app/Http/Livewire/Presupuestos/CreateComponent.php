<?php


namespace App\Http\Livewire\Presupuestos;

use App\Models\Paciente;
use App\Models\Aseguradora;
use App\Models\EstadoPresupuesto;
use App\Models\Presupuesto;
use App\Models\Servicio;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateComponent extends Component
{
    use LivewireAlert, WithFileUploads;

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
    public $total;
    public $archivo;
    public $usarServicios = false; // Para determinar si se usan servicios o solo total

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

    public function addServicio()
    {
        if (!isset($this->servicio_seleccionado)) {
            return;
        }
        $servicio = Servicio::find($this->servicio_seleccionado);
        $this->listaServicios[] = [
            'nombre' => $servicio->nombre,
            'descripcion' => $servicio->descripcion,
            'precio' => $servicio->precio,
            'iva' => $servicio->iva ?? null,
        ];
        $this->servicio_seleccionado = null;
        $this->emit('resetSelect2');
    }

    public function deleteServicio($indice)
    {
        unset($this->listaServicios[$indice]);
        $this->listaServicios = array_values($this->listaServicios);
    }

    public function submit()
    {
        $validatedData = $this->validate(
            [
                'paciente_id' => 'required',
                'aseguradora_id' => 'nullable',
                'observacion' => 'nullable',
                'fechaEmision' => 'required',
                'estado_id' => 'required',
                'total' => 'required_if:usarServicios,false|nullable|numeric',
                'archivo' => 'nullable|file|max:1024', // 1MB Max
            ],
            [
                'fechaEmision.required' => 'La Fecha es obligatoria.',
                'estado_id.required' => 'El Estado es obligatorio.',
                'paciente_id.required' => 'El Paciente es obligatorio.',
                'total.required_if' => 'El Total es obligatorio cuando no se utilizan servicios.',
                'archivo.max' => 'El archivo no debe superar 1MB.',
            ]
        );

        if ($this->archivo) {
            $validatedData['archivo'] = $this->archivo->store('archivos_presupuestos');
        }

        $presupuesto = Presupuesto::create($validatedData);
        $this->identificador = $presupuesto->id;

        event(new \App\Events\LogEvent(Auth::user(), 3, $presupuesto->id));

        if ($this->usarServicios) {
            foreach ($this->listaServicios as $servicio) {
                $presupuesto->servicios()->create($servicio);
            }
        }

        if ($presupuesto) {
            $this->alert('success', '¡Presupuesto registrado correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmedEdit',
                'confirmButtonText' => 'Seguir editando',
                'showDenyButton' => true,
                'denyButtonText' => 'Ir a lista',
                'onDenied' => 'confirmed',
                'timer' => null,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del presupuesto!', [
                'position' => 'center',
                'toast' => false,
            ]);
        }
    }

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

    public function confirmedEdit()
    {
        return redirect()->route('presupuestos.edit', $this->identificador);
    }

    public function confirmed()
    {
        return redirect()->route('presupuestos.index');
    }

}
