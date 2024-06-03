<?php

namespace App\Http\Livewire\Plataformas;

use App\Models\Aseguradora;
use App\Models\Empresa;
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

    public function mount()
    {
        $plataforma = Plataforma::find($this->identificador);

        $this->nombre = $plataforma->nombre;
        $this->telefono = $plataforma->telefono;
        $this->email = $plataforma->email;
        $this->codigoPostal = $plataforma->codigoPostal;
        $this->direccion = $plataforma->direccion;
        $this->poblacion = $plataforma->poblacion;
        $this->provincia = $plataforma->provincia;
    }

    public function render()
    {
        return view('livewire.plataformas.edit-component');
    }

    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate([
            'nombre'=> 'nullable',
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
            ]);

        // Encuentra el identificador
        $plataforma = Plataforma::find($this->identificador);

        // Guardar datos validados
        $plataformaSave = $plataforma->update([
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'codigoPostal' => $this->codigoPostal,
            "direccion"=> $this->direccion,
            "poblacion"=> $this->poblacion,
            "provincia"=> $this->provincia,

        ]);
        event(new \App\Events\LogEvent(Auth::user(), 9, $plataforma->id));

        if ($plataformaSave) {
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
        return redirect()->route('plataformas.index');

    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $plataforma = Plataforma::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 10, $plataforma->id));
        $plataforma->delete();
        return redirect()->route('plataformas.index');

    }
}
