<?php

namespace App\Http\Livewire\Servicios;

use Illuminate\Support\Facades\Redirect;
use App\Models\Servicio;
use App\Models\Articulos;
use App\Models\ServicioCategoria;
use App\Models\ServicioPack;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;
    public $nombre;
    public $precio;
    public $descripcion;
    public $iva;


    public function mount()
    {
        $servicio = Servicio::find($this->identificador);
        $this->nombre = $servicio->nombre;
        $this->precio = $servicio->precio;
        $this->descripcion = $servicio->descripcion;
        $this->iva = $servicio->iva;
    }

    public function render()
    {
        return view('livewire.servicios.edit-component');
    }

    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate(
            [
                'nombre' => 'required',
                'precio' => 'required',
                'descripcion' => 'nullable',
                'iva' => 'nullable',


            ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'precio.required' => 'El precio base es obligatorio.',

            ]
        );

        // Encuentra el identificador
        $servicio = Servicio::find($this->identificador);

        // Guardar datos validados

        $servicioSave = $servicio->update([
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'descripcion' => $this->descripcion,
            'iva' => $this->iva,
        ]);
        event(new \App\Events\LogEvent(Auth::user(), 30, $servicio->id));

        if ($servicioSave) {
            $this->alert('success', '¡Servicio actualizado correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del servicio!', [
                'position' => 'center',
                'toast' => false,
            ]);
        }

        session()->flash('message', 'Servicio actualizado correctamente.');

        $this->emit('eventUpdated');
    }


    // Eliminación
    public function destroy()
    {

        $this->alert('warning', '¿Seguro que desea borrar el usuario? No hay vuelta atrás', [
            'position' => 'center',
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
            'confirmDelete',
            'update',
            'destroy'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('servicios.index');
    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $servicio = Servicio::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 31, $servicio->id));
        $servicio->delete();
        return redirect()->route('servicios.index');
    }
}
