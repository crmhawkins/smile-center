<?php

namespace App\Http\Livewire\Monitores;

use App\Models\Monitor;
//use App\Models\Servicio;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $identificador;

    public $nombre;
    public $apellidos;
    public $contacto;
    public $parentesco;
    public $fechaNa;
    public $lugar;
    public $localidad;
    public $telefono;


    public function mount()
    {

    }



    public function render()
    {
        return view('livewire.monitores.create-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'localidad' => 'required',
            'telefono' => 'required',
            'fechaNa' => 'required',

        ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'apellidos.required' => 'Los protagonistas son obligatorio.',
                'localidad.required' => 'La localidad es obligatoria.',
                'telefono.required' => 'El telefono es obligatorio.',
                'fechaNa.required' => 'El telefono es obligatorio.',
            
            ]);

        // Guardar datos validados
        $monitorSave = Monitor::create($validatedData);

        // Alertas de guardado exitoso
        if ($monitorSave) {
            $this->alert('success', '¡Usuario registrado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del usuario!', [
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
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('monitor.index');
    }
}
