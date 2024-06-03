<?php

namespace App\Http\Livewire\Leads;

use App\Models\Aseguradora;
use App\Models\Empresa;
use App\Models\EstadoPacientes;
use App\Models\Paciente;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $codigoPostal;
    public $direccion;
    public $poblacion;
    public $provincia;
    public $referido_id;
    public $empresa_id;
    public $aseguradora_id;
    public $origen;
    public $newsletter;
    public $aseguradoras;
    public $empresas;
    public $pacientes;
    public $estado_id = 1;
    public $estados;

    public function mount()
    {
        $this->pacientes = Paciente::where('estado_id',3)->get();
        $this->estados = EstadoPacientes::all();
        $this->empresas = Empresa::all();
        $this->aseguradoras = Aseguradora::all();
    }

    public function render()
    {
        return view('livewire.leads.create-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                'nombre'=> 'required',
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
            ]
        );

        // Guardar datos validados
        $clienteSave = Paciente::create(
            $validatedData
        );

        event(new \App\Events\LogEvent(Auth::user(), 8, $clienteSave->id));

        // Alertas de guardado exitoso
        if ($clienteSave) {
            $this->alert('success', '¡Paciente registrado correctamente!', [
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
        return redirect()->route('leads.index');
    }
}
