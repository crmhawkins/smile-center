<?php

namespace App\Http\Livewire\Citas;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditComponent extends Component
{
    use LivewireAlert;
    public $identificador;
    public $presupuestos;
    public $pacientes;
    public $presupuesto_id;
    public $paciente_id;
    public $fecha;
    public $hora;
    public $asistencia;
    public $user_id;
    public $observacion;

    public function mount()
    {
        $cita = Cita::find($this->identificador);
        $this->presupuestos = Presupuesto::all();
        $this->pacientes = Paciente::all();
        $this->presupuesto_id = $cita->presupuesto_id;
        $this->user_id = $cita->presupuesto_id;
        $this->paciente_id = $cita->paciente_id;
        $this->fecha = $cita->fecha;
        $this->hora = $cita->hora;
        $this->asistencia = $cita->asistencia;
        $this->observacion = $cita->observacion;

    }
    public function render()
    {
        return view('livewire.citas.edit-component');
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
    public function update()
    {
        $cita = Cita::find($this->identificador);
        if($this->presupuesto_id == ""){
            $this->presupuesto_id = null;
        }
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
        $citaSave = $cita->update(
            $validatedData
        );

        event(new \App\Events\LogEvent(Auth::user(), 15, $cita->id));

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
            'update',
            'destroy',
            'confirmDelete',
        ];
    }
    public function destroy(){

        $this->alert('warning', '¿Seguro que desea borrar la cita? No hay vuelta atrás', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmDelete',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);

    }
    public function confirmDelete()
    {
        $cita = Cita::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 16, $cita->id));
        $cita->delete();
        return redirect()->route('citas.index');
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('citas.index');
    }
}
