<?php

namespace App\Http\Livewire\Aseguradoras;

use App\Models\Aseguradora;
use App\Models\Plataforma;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;
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
        $aseguradora = Aseguradora::find($this->identificador);
        $this->plataformas = Plataforma::all();
        $this->nombre = $aseguradora->nombre;
        $this->email = $aseguradora->email;
        $this->telefono = $aseguradora->telefono;
        $this->codigoPostal = $aseguradora->codigoPostal;
        $this->direccion = $aseguradora->direccion;
        $this->poblacion = $aseguradora->poblacion;
        $this->provincia = $aseguradora->provincia;
        $this->plataforma_id = $aseguradora->apellido;
    }

    public function render()
    {
        return view('livewire.aseguradoras.edit-component');
    }

    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate([
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
            ]);

        // Encuentra el identificador
        $aseguradora = Aseguradora::find($this->identificador);

        // Guardar datos validados
        $aseguradoraSave = $aseguradora->update([
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'codigoPostal' => $this->codigoPostal,
            "direccion"=> $this->direccion,
            "poblacion"=> $this->poblacion,
            "provincia"=> $this->provincia,
            "plataforma_id"=> $this->plataforma_id,

        ]);
        event(new \App\Events\LogEvent(Auth::user(), 9, $aseguradora->id));

        if ($aseguradoraSave) {
            $this->alert('success', '!Aseguradora actualizada correctamente!', [
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

        session()->flash('message', 'Aseguradora actualizada correctamente.');

        $this->emit('eventUpdated');
    }

      // Eliminación
      public function destroy(){

        $this->alert('warning', '¿Seguro que desea borrar la aseguradora? No hay vuelta atrás', [
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
        return redirect()->route('aseguradoras.index');

    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $aseguradora = Aseguradora::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 10, $aseguradora->id));
        $aseguradora->delete();
        return redirect()->route('aseguradoras.index');

    }
}
