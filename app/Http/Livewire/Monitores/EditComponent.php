<?php

namespace App\Http\Livewire\Monitores;

use App\Models\Evento;
use App\Models\Monitor;
use App\Models\Programa;
use App\Models\Servicio;
use App\Models\ServicioEvento;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;

    public $nombre;
    public $apellidos;
    public $contacto;
    public $parentesco;
    public $lugar;
    public $fechaNa;
    public $localidad;
    public $telefono;

    //Historial
    public $programas;
    public $eventos;
    public $servicios;
    public $vecesContratado;

    //debug
    public $eventos_id;

    public function mount()
    {
        $monitor = Monitor::find($this->identificador);


        $this->nombre = $monitor->nombre;
        $this->apellidos = $monitor->apellidos;
        $this->telefono = $monitor->telefono;
        $this->fechaNa = $monitor->fechaNa;
        $this->lugar = $monitor->lugar;
        $this->localidad = $monitor->localidad;

        $this->programas = Programa::where('id_monitor', $this->identificador)->get();
        $servicios_id = $this->programas->pluck("id_servicio")->toArray();
        $this->servicios =  Servicio::whereIn("id", $servicios_id)->get();

        $this->vecesContratado = count($this->programas);
    }

    public function getEventoFromIdServicioEvento($id){
        $servicioEvento = ServicioEvento::where("id", $id)->first();

        $evento = Evento::where("id", $servicioEvento->id_evento)->first();

        return $evento->eventoNombre;
    }
    public function getServicioFromIdServicioEvento($id){
        $servicioEvento = ServicioEvento::where("id", $id)->first();

        $servicio = Servicio::where("id", $servicioEvento->id_servicio)->first();

        return $servicio->nombre;
    }

    public function render()
    {
        return view('livewire.monitores.edit-component');
    }

    // public function crearServicio()
    // {
    //     return Redirect::to(route("servicios.create"));
    // }

    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'localidad' => 'required',
            'telefono' => 'required',
        ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'apellidos.required' => 'Los protagonistas son obligatorio.',
                'localidad.required' => 'La localidad es obligatoria.',
                'telefono.required' => 'El telefono es obligatorio.',
            
            ]);

        // Encuentra el identificador
        $monitor = Monitor::find($this->identificador);

        // Guardar datos validados
        $monitorSave = $monitor->update([
            'nombre' => $this->nombre,
            'apellidos'=>$this->apellidos,
            'localidad' => $this->localidad,
            'telefono'=>$this->telefono,
        ]);
        event(new \App\Events\LogEvent(Auth::user(), 21, $monitor->id));

        if ($monitorSave) {
            $this->alert('success', 'Monitor actualizado correctamente!', [
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

        session()->flash('message', 'Monitor actualizado correctamente.');

        $this->emit('eventUpdated');
    }

      // Eliminación
      public function destroy(){

        $this->alert('warning', '¿Seguro que desea borrar el monitor? No hay vuelta atrás', [
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
            'confirmDelete',
            'update',
            'destroy'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('monitor.index');

    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $monitor = Monitor::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 22, $monitor->id));
        $monitor->delete();
        return redirect()->route('monitor.index');

    }
}
