<?php

namespace App\Http\Livewire\Empresas;

use App\Models\Empresa;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;
    public $nombre;
    public $contacto;
    public $cargo;
    public $email;
    public $telefono;
    public $codigoPostal;
    public $direccion;
    public $poblacion;
    public $provincia;

    public function mount()
    {
        $empresa = Empresa::find($this->identificador);
        $this->nombre = $empresa->nombre;
        $this->email = $empresa->email;
        $this->telefono = $empresa->telefono;
        $this->codigoPostal = $empresa->codigoPostal;
        $this->direccion = $empresa->direccion;
        $this->poblacion = $empresa->poblacion;
        $this->provincia = $empresa->provincia;
        $this->contacto = $empresa->provincia;
        $this->cargo = $empresa->provincia;
    }

    public function render()
    {
        return view('livewire.empresas.edit-component');
    }

    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate([
            'nombre'=> 'nullable',
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
            ]);

        // Encuentra el identificador
        $paciente = Empresa::find($this->identificador);

        // Guardar datos validados
        $pacienteSave = $paciente->update([
            'nombre' => $this->nombre,
            'contacto'=>$this->contacto,
            'cargo'=>$this->cargo,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'codigoPostal' => $this->codigoPostal,
            "direccion"=> $this->direccion,
            "poblacion"=> $this->poblacion,
            "provincia"=> $this->provincia,

        ]);
        event(new \App\Events\LogEvent(Auth::user(), 9, $paciente->id));

        if ($pacienteSave) {
            $this->alert('success', 'Empresa actualizada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información de la Empresa!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }

        session()->flash('message', 'Empresa actualizada correctamente.');

        $this->emit('eventUpdated');
    }

      // Eliminación
      public function destroy(){

        $this->alert('warning', '¿Seguro que desea borrar la empresa? No hay vuelta atrás', [
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
        return redirect()->route('empresas.index');

    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $cliente = Empresa::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 10, $cliente->id));
        $cliente->delete();
        return redirect()->route('empresas.index');

    }
}
