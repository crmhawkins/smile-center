<?php

namespace App\Http\Livewire\Leads;

use App\Models\Aseguradora;
use App\Models\Empresa;
use App\Models\EstadoPacientes;
use App\Models\Paciente;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $codigoPostal;
    public $direccion;
    public $poblacion;
    public $provincia;
    public $estado_id;
    public $referido_id;
    public $empresa_id;
    public $aseguradora_id;
    public $origen;
    public $newsletter;
    public $aseguradoras;
    public $empresas;
    public $pacientes;
    public $estados;

    public function mount()
    {
        $paciente = Paciente::find($this->identificador);
        $this->aseguradoras = Aseguradora::all();
        $this->empresas = Empresa::all();
        $this->pacientes = Paciente::where('estado_id',3)->get();
        $this->estados = EstadoPacientes::all();
        $this->nombre = $paciente->nombre;
        $this->apellido = $paciente->apellido;
        $this->email = $paciente->email;
        $this->telefono = $paciente->telefono;
        $this->codigoPostal = $paciente->codigoPostal;
        $this->direccion = $paciente->direccion;
        $this->poblacion = $paciente->poblacion;
        $this->provincia = $paciente->provincia;
        $this->estado_id = $paciente->estado_id;
        $this->referido_id = $paciente->referido_id;
        $this->empresa_id = $paciente->empresa_id;
        $this->aseguradora_id = $paciente->aseguradora_id;
        $this->origen = $paciente->origen;
        $this->newsletter = $paciente->newsletter;
    }

    public function render()
    {
        return view('livewire.leads.edit-component');
    }

    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate([
            'nombre'=> 'nullable',
            'apellido'=> 'nullable',
            "email"=> 'nullable',
            "telefono"=> 'nullable',
            "codigoPostal"=> 'nullable',
            "direccion"=> 'nullable',
            "poblacion"=> 'nullable',
            "provincia"=> 'nullable',
            "referido_id"=> 'nullable',
            "empresa_id"=> 'nullable',
            "aseguradora_id"=> 'nullable',
            "origen"=> 'nullable',
            "newsletter"=> 'nullable',
            "estado_id"=> 'nullable',

        ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
            ]);

        // Encuentra el identificador
        $paciente = Paciente::find($this->identificador);

        // Guardar datos validados
        $pacienteSave = $paciente->update([
            'nombre' => $this->nombre,
            'apellido'=>$this->apellido,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'codigoPostal' => $this->codigoPostal,
            "direccion"=> $this->direccion,
            "poblacion"=> $this->poblacion,
            "provincia"=> $this->provincia,
            "referido_id"=> $this->referido_id,
            "empresa_id"=> $this->empresa_id,
            "aseguradora_id"=> $this->aseguradora_id,
            "origen"=> $this->origen,
            "newsletter"=> $this->newsletter,
            "estado_id"=> $this->estado_id,
        ]);
        event(new \App\Events\LogEvent(Auth::user(), 9, $paciente->id));

        if ($pacienteSave) {
            $this->alert('success', 'Paciente actualizado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del paciente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }

        session()->flash('message', 'paciente actualizado correctamente.');

        $this->emit('eventUpdated');
    }

      // Eliminación
      public function destroy(){

        $this->alert('warning', '¿Seguro que desea borrar el paciente? No hay vuelta atrás', [
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

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'update',
            'destroy',
            'confirmDelete'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('leads.index');

    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $cliente = Paciente::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 10, $cliente->id));
        $cliente->delete();
        return redirect()->route('leads.index');

    }
}
