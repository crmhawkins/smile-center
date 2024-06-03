<?php

namespace App\Http\Livewire\Servicios;

use App\Models\Servicio;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $nombre;
    public $precio;
    public $descripcion;
    public $iva;

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.servicios.create-component');
    }

    public function submit()
    {

        // Validación de datos
        $validatedData = $this->validate(
            [
                'nombre' => 'required',
                'precio' => 'required',
                'descripcion' => 'nullable',
                'iva' => 'nullable',
            ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'precio.required' => 'El precio es obligatorio.',

            ]
        );

        // Guardar datos validados
        $servicioSave = Servicio::create($validatedData);
        event(new \App\Events\LogEvent(Auth::user(), 29, $servicioSave->id));

        $servicioSave->save();
        // Alertas de guardado exitoso
        if ($servicioSave) {
            $this->alert('success', 'Servicio registrado correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del usuario!', [
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
            'submit'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('servicios.index');
    }
}
