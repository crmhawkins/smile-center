<?php

namespace App\Http\Livewire\Clientes;

use App\Models\Cliente;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;

    public $trato;
    public $nombre;
    public $apellido;
    public $tipoCalle; 
    public $calle;
    public $numero;
    public $direccionAdicional1;
    public $direccionAdicional2;
    public $direccionAdicional3;
    public $codigoPostal;
    public $ciudad;
    public $nif;
    public $tlf1;
    public $tlf2;
    public $tlf3;
    public $email1;
    public $email2;
    public $email3;
    public $confPostal;
    public $confEmail;
    public $confSms;

    public function mount()
    {
        $cliente = Cliente::find($this->identificador);


        $this->trato = $cliente->trato;
        $this->nombre = $cliente->nombre;
        $this->apellido = $cliente->apellido;
        $this->tipoCalle = $cliente->tipoCalle;
        $this->calle = $cliente->calle;
        $this->numero = $cliente->numero;
        $this->direccionAdicional1 = $cliente->direccionAdicional1;
        $this->direccionAdicional2 = $cliente->direccionAdicional2;
        $this->direccionAdicional3 = $cliente->direccionAdicional3;
        $this->codigoPostal = $cliente->codigoPostal;
        $this->ciudad = $cliente->ciudad;
        $this->nif = $cliente->nif;
        $this->tlf1 = $cliente->tlf1;
        $this->tlf2 = $cliente->tlf2;
        $this->tlf3 = $cliente->tlf3;
        $this->email1 = $cliente->email1;
        $this->email2 = $cliente->email2;
        $this->email3 = $cliente->email3;

    }

    
    public function render()
    {
        return view('livewire.clientes.edit-component');
    }


    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'tipoCalle' => 'required',
            'calle' => 'required',
            'numero' => 'required',
            'codigoPostal'=> 'required',
            'ciudad' => 'required',
            'nif' => 'required',
            'tlf1' => 'required',
            'email1' => 'required',
        ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'apellido.required' => 'Los protagonistas son obligatorio.',
                'tipoCalle.required' => 'La cantidad de niños es obligatoria.',
                'calle.required' => 'El nombre de usuario es obligatorio.',
                'numero.required' => 'La contraseña es obligatoria.',
                'codigoPostal.required' => 'El lugar es obligatorio.',
                'ciudad.required' => 'La localidad es obligatoria.',
                'nif.required' => 'El telefono es obligatorio.',
                'tlf1.required' => 'El telefono es obligatorio.',
                'email1.required' => 'El telefono es obligatorio.',
            
            ]);

        // Encuentra el identificador
        $cliente = Cliente::find($this->identificador);

        // Guardar datos validados
        $clienteSave = $cliente->update([
            'nombre' => $this->nombre,
            'apellido'=>$this->apellido,
            'tipoCalle' => $this->tipoCalle,
            'calle' => $this->calle,
            'numero' => $this->numero,
            'direccionAdicional1' => $this->direccionAdicional1,
            'direccionAdicional2' => $this->direccionAdicional2,
            'direccionAdicional3' => $this->direccionAdicional3,
            'codigoPostal' => $this->codigoPostal,
            'ciudad' => $this->ciudad,
            'nif'=>$this->nif,
            'tlf1'=>$this->tlf1,
            'tlf2'=>$this->tlf2,
            'tlf3'=>$this->tlf3,
            'email1'=>$this->email1,
            'email2'=>$this->email2,
            'email3'=>$this->email3,
        ]);

        if ($clienteSave) {
            $this->alert('success', 'Usuario actualizado correctamente!', [
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

        session()->flash('message', 'cliente actualizado correctamente.');

        $this->emit('eventUpdated');
    }

      // Eliminación
      public function destroy(){

        $this->alert('warning', '¿Seguro que desea borrar el usuario? No hay vuelta atrás', [
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
            'confirmDelete'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('clientes.index');

    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $cliente = Cliente::find($this->identificador);
        $cliente->delete();
        return redirect()->route('clientes.index');

    }
}
