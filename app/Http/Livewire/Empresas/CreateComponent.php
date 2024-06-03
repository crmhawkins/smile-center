<?php

namespace App\Http\Livewire\Empresas;

use App\Models\Empresa;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $nombre;
    public $contacto;
    public $cargo;
    public $email;
    public $telefono;
    public $codigoPostal;
    public $direccion;
    public $poblacion;
    public $provincia;


    public function render()
    {
        return view('livewire.empresas.create-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                'nombre'=> 'required',
                "email"=> 'nullable',
                "telefono"=> 'nullable',
                "codigoPostal"=> 'nullable',
                "direccion"=> 'nullable',
                "poblacion"=> 'nullable',
                "provincia"=> 'nullable',
                "contacto"=> 'nullable',
                "cargo"=> 'nullable',
            ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
            ]
        );

        // Guardar datos validados
        $clienteSave = Empresa::create(
            $validatedData
        );

        event(new \App\Events\LogEvent(Auth::user(), 8, $clienteSave->id));

        // Alertas de guardado exitoso
        if ($clienteSave) {
            $this->alert('success', '¡Empresa registrada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información de la empresa!', [
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
        return redirect()->route('empresas.index');
    }
}
