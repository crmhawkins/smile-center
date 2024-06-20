<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\Paciente;
use App\Models\Aseguradora;
use App\Models\EstadoPresupuesto;
use App\Models\Presupuesto;
use App\Models\Servicio;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditComponent extends Component
{
    use LivewireAlert, WithFileUploads;

    public $identificador;
    public $paciente_id;
    public $pacientes;
    public $aseguradora_id;
    public $aseguradoras;
    public $estado_id;
    public $observacion;
    public $servicios;
    public $fechaEmision;
    public $estados;
    public $listaServicios = [];
    public $servicio_seleccionado;
    public $total;
    public $archivo;
    public $archivoNombre;
    public $usarServicios = false;
    public $ServiciosDelete = [];

    public function mount()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        $this->pacientes = Paciente::all();
        $this->estados = EstadoPresupuesto::all();
        $this->servicios = Servicio::all();
        $this->aseguradoras = Aseguradora::all();
        $this->paciente_id = $presupuesto->paciente_id;
        $this->aseguradora_id = $presupuesto->aseguradora_id;
        $this->estado_id = $presupuesto->estado_id;
        $this->observacion = $presupuesto->observacion;
        $this->fechaEmision = $presupuesto->fechaEmision;
        $this->listaServicios = $presupuesto->servicios()->get()->toArray();
        $this->total = $presupuesto->total;
        $this->archivoNombre = $presupuesto->archivo;
        $this->usarServicios = !is_null($presupuesto->servicios()->first());
    }

    public function render()
    {
        return view('livewire.presupuestos.edit-component');
    }

    public function addServicio()
    {
        if (!isset($this->servicio_seleccionado)) {
            return;
        }
        $servicio = Servicio::find($this->servicio_seleccionado);
        $this->listaServicios[] = [
            'nombre' => $servicio->nombre,
            'descripcion' => $servicio->descripcion,
            'precio' => $servicio->precio,
            'iva' => $servicio->iva ?? null,
        ];
        $this->servicio_seleccionado = null;
        $this->emit('resetSelect2');
    }

    public function deleteServicio($key)
    {
        if (isset($this->listaServicios[$key]["id"])) {
            $this->ServiciosDelete[] = $this->listaServicios[$key]['id'];
        }
        unset($this->listaServicios[$key]);
        $this->listaServicios = array_values($this->listaServicios);
    }

    public function update()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        $validatedData = $this->validate(
            [
                'paciente_id' => 'required',
                'aseguradora_id' => 'nullable',
                'observacion' => 'nullable',
                'fechaEmision' => 'required',
                'estado_id' => 'required',
                'total' => 'required_if:usarServicios,false|nullable|numeric',
                'archivo' => 'nullable|file|max:1024', // 1MB Max
            ],
            [
                'fechaEmision.required' => 'La Fecha es obligatoria.',
                'estado_id.required' => 'El Estado es obligatorio.',
                'paciente_id.required' => 'El Paciente es obligatorio.',
                'total.required_if' => 'El Total es obligatorio cuando no se utilizan servicios.',
                'archivo.max' => 'El archivo no debe superar 1MB.',
            ]
        );

        if ($this->archivo) {
            $validatedData['archivo'] = $this->archivo->store('archivos_presupuestos','public');
            if ($presupuesto->archivo) {
                Storage::delete($presupuesto->archivo);
            }
        }

        $presupuesto->update($validatedData);
        event(new \App\Events\LogEvent(Auth::user(), 6, $presupuesto->id));

        foreach ($this->ServiciosDelete as $servicio) {
            $presupuesto->servicios()->where('id', $servicio)->delete();
        }

        if ($this->usarServicios) {
            foreach ($this->listaServicios as $servicio) {
                if (empty($servicio['id'])) {
                    $presupuesto->servicios()->create($servicio);
                }
            }
        } else {
            $presupuesto->servicios()->delete();
        }

        if ($presupuesto) {
            $this->alert('success', '¡Presupuesto actualizado correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido actualizar la información del presupuesto!', [
                'position' => 'center',
                'toast' => false,
            ]);
        }
    }

    public function destroy()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        $presupuesto->servicios()->delete();
        $presupuesosSave = $presupuesto->delete();

        if ($presupuesosSave) {
            $this->alert('success', '¡Presupuesto eliminado correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido actualizar la información del presupuesto!', [
                'position' => 'center',
                'toast' => false,
            ]);
        }
    }

    public function getListeners()
    {
        return [
            'confirmed',
            'destroy',
            'confirmed',
            'imprimirPresupuesto',
            'update',
            'cita',
        ];
    }

    public function confirmed()
    {
        return redirect()->route('presupuestos.index');
    }

    public function cita()
    {
        return redirect()->route('citas.create', ['id' => $this->identificador]);
    }

    public function alertaImprimir()
    {
        $this->alert('info', '¿Desea descargar el presupuesto en PDF?', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'imprimirPresupuesto',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }

    public function alertaGuardar()
    {
        $this->alert('info', '¿Desea actualizar los datos del presupuesto?', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'update',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }

    public function alertaEliminar()
    {
        $this->alert('error', '¿Seguro que desea eliminar el presupuesto? No se puede revertir este proceso.', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'destroy',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
            'timer' => null
        ]);
    }

    public function crearCita()
    {
        $this->alert('info', '¿Desea generar una cita a partir del presupuesto?', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'cita',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
            'timer' => null
        ]);
    }

    public function imprimirPresupuesto()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        $listaServicios = $presupuesto->servicios()->get();
        $paciente = Paciente::find($presupuesto->paciente_id);

        $datos = [
            'presupuesto' => $presupuesto,
            'listaServicios' => $listaServicios,
            'paciente' => $paciente,
        ];

        $pdf = Pdf::loadView('livewire.presupuestos.pdf-component', $datos)->setPaper('a4', 'vertical')->output();
        return response()->streamDownload(
            fn() => print($pdf),
            'Presupuesto_' . $this->identificador . '.pdf'
        );
    }

    public function descargarArchivo()
    {
        return Storage::download($this->archivoNombre);
    }

    public function updatedUsarServicios()
    {
        $this->reset(['total', 'listaServicios']);
    }
}
