<?php

namespace App\Http\Livewire\Aseguradoras;

use App\Models\Aseguradora;
use App\Models\Plataforma;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $nombre;
    public $telefono;
    public $email;
    public $codigoPostal;
    public $direccion;
    public $poblacion;
    public $provincia;
    public $plataforma_id;
    public $plataformas;


    public function mount()
    {
        $this->plataformas = Plataforma::all();
    }

    public function render()
    {
        return view('livewire.aseguradoras.create-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                'nombre'=> 'required',
                "telefono"=> 'nullable',
                "email"=> 'nullable',
                "codigoPostal"=> 'nullable',
                "direccion"=> 'nullable',
                "poblacion"=> 'nullable',
                "provincia"=> 'nullable',
                'plataforma_id'=> 'nullable',
            ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
            ]
        );

        // Guardar datos validados
        $aseguradoraSave = Aseguradora::create(
            $validatedData
        );

        event(new \App\Events\LogEvent(Auth::user(), 8, $aseguradoraSave->id));

        // Alertas de guardado exitoso
        if ($aseguradoraSave) {
            $this->alert('success', '¡Aseguradora registrada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información de la aseguradora!', [
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
        return redirect()->route('aseguradoras.index');
    }
}
