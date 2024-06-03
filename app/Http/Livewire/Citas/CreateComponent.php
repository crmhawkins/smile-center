<?php

namespace App\Http\Livewire\Citas;

use App\Models\Alertas;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateComponent extends Component
{
    use LivewireAlert;
    public $presupuestos;
    public $pacientes;
    public $presupuesto_id;
    public $paciente_id;
    public $fecha;
    public $hora;
    public $asistencia;
    public $observacion;
    public $user_id;

    public function mount()
    {

        $this->presupuestos = Presupuesto::all();
        $this->pacientes = Paciente::all();
        $this->user_id = Auth::user()->id;
        if(isset($this->presupuesto_id)){
            $this->asignarPresupuesto();
        }
    }

    public function render()
    {
        return view('livewire.citas.create-component');
    }

    public function asignarPresupuesto()
    {
        $presupuesto = $this->presupuestos->find($this->presupuesto_id);

        if ($presupuesto) {
            $this->paciente_id = $presupuesto->paciente_id;
        }else{
            $this->paciente_id = null;
        }
    }

    public function updatedPresupuestoId($value)
    {
        $this->asignarPresupuesto();
    }

    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                "presupuesto_id"=> 'nullable',
                "paciente_id"=> 'required',
                "fecha"=> 'required',
                "hora"=> 'nullable',
                "asistencia"=> 'nullable',
                'observacion'=> 'nullable',
                'user_id'=> 'nullable',

            ],
            // Mensajes de error
            [
                'paciente_id.required' => 'El paciente es obligatorio.',
                'fecha.required' => 'La fechas es obligatoria.',
            ]
        );

        // Guardar datos validados
        $citaSave = Cita::create(
            $validatedData
        );

        event(new \App\Events\LogEvent(Auth::user(), 14, $citaSave->id));

        Alertas::create([
                'user_id' => Auth::user()->id,
                'tipo' => 1,
                'titulo' => "Nueva Cita",
                'descripcion' => 'Nueva cita generada para el '.$this->fecha.' a las '.$this->hora.' con el paciente '. $this->pacientes->find($this->paciente_id)->nombre,
        ]);

        // Alertas de guardado exitoso
        if ($citaSave) {
            $this->alert('success', '¡Cita registrada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información de la cita!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'submit'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('citas.index');
    }
}
