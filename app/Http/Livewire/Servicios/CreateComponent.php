<?php

namespace App\Http\Livewire\Servicios;

use Illuminate\Support\Facades\Redirect;
use App\Models\Servicio;
use App\Models\ServicioCategoria;
use App\Models\ServicioPack;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $nombre;
    public $precioBase;
    public $id_pack; 
    public $id_categoria;
    public $minMonitor;
    public $precioMonitor;
    public $servicioCategorias;
    public $servicioPacks;


    public function mount(){
        $this->servicioCategorias = ServicioCategoria::all();
        $this->servicioPacks = ServicioPack::all();
    }

    public function precioTotal(){
        return intval($this->minMonitor) * intval($this->precioMonitor) + floatval($this->precioBase);

    }

    public function crearCategoria()
    {
        return Redirect::to(route("servicios-categorias.create"));
    }

    public function crearPack()
    {
        return Redirect::to(route("servicios-packs.create"));
    }

    public function render()
    {
        return view('livewire.servicios.create-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        
        // Validación de datos
        $validatedData = $this->validate([
            'nombre' => 'required',
            'precioBase' => 'required',
            'id_pack' => 'required',
            'id_categoria' => 'required',
            'minMonitor' => 'required',
            'precioMonitor' => 'required',

        ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'precioBase.required' => 'El precio base son obligatorio.',
                'id_pack.required' => 'El campo pack es obligatoria.',
                'id_categoria.required' => 'El campo categoria es obligatorio.',
                'minMonitor.required' => 'El el numero minimo de monitores es obligatorio.',
                'precioMonitor.required' => 'El el precio minimo por monitor es obligatorio.',
            ]);

        // Guardar datos validados
        $usuariosSave = Servicio::create($validatedData);

        // Alertas de guardado exitoso
        if ($usuariosSave) {
            $this->alert('success', 'Servicio registrado correctamente!', [
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
        return redirect()->route('servicios.index');

    }
}
