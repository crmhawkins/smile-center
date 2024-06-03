<?php

namespace App\Http\Livewire\Plataformas;

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


    public function render()
    {
        return view('livewire.plataformas.create-component');
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
            ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
            ]
        );

        // Guardar datos validados
        $plataformaSave = Plataforma::create(
            $validatedData
        );

        event(new \App\Events\LogEvent(Auth::user(), 8, $plataformaSave->id));

        // Alertas de guardado exitoso
        if ($plataformaSave) {
            $this->alert('success', '!Plataforma registrada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información de la plataforma!', [
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
        return redirect()->route('plataformas.index');
    }
}
