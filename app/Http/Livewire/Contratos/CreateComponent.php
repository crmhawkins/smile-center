<?php

namespace App\Http\Livewire\Contratos;

use App\Models\Evento;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\MetodoPago;
use App\Models\ServicioEvento;
use App\Models\CuentaBancaria;
use App\Models\Monitor;
use App\Models\Empresa;
use App\Models\Presupuesto;
use App\Models\Programa;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;
use IntlDateFormatter;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $empresa;

    public $presupuestos;
    public $presupuesto;
    public $id_presupuesto;

    //contrato Servicios
    public $nContrato;
    public $diaEvento;
    public $observaciones = "";



    //cliente
    public $id_cliente;
    public $trato = null;
    public $nombre;
    public $apellido;



    // Evento

    public $diaFinal;



    //Monitores
    public $monitores;

    // Servicios
    public $evento;
    public $id_evento;
    public $dia;

    public $servicioEventoList = [];

    public $servicioIsSave;


    public $servicios;


    public $servicio;

    public $eventoServicios;
    public $programas;
    public $listaServicios;
    public $clientes;



    public $nDias;

    // pricing


    public $total;
    public $precioBase;
    public $entrega;
    public $adelanto;
    public $metodosPago;
    public $metodoPago;
    public $metodoTransferencia;
    public $cuentas;
    public $cuentaTransferencia;

 

    //triggers
    public $isTransferencia = false;


    public $fechaContrato;

    //Consentimiento
    public $authImagen = 0;
    public $authMenores = 0;
    public $responsableTratamiento;

    protected $listeners = [
        'confirmed' => 'confirmed',
        'isTransferencia' => 'isTransferencia',
        'loadPrice' => 'loadPrice',
    ];



    public function mount()
    {

        $this->empresa = Empresa::find("1");

        $this->presupuestos = Presupuesto::all();

        //Autoincrementa automaticamente el numero del contrato antes de que se cree

        $this->nContrato = Contrato::max("id") + 1;
        $this->monitores = Monitor::all();
        $this->metodosPago = MetodoPago::all();
        $this->cuentas = CuentaBancaria::all();
        
        $this->metodoTransferencia = count($this->metodosPago) != 0 ? $this->metodosPago->where("nombre", "Transferencia")->first()->id : '';


        $this->dia = $this->diaEvento;
        $this->fechaContrato = now();
    }


    public function loadPresupuesto()
    {
        $this->emit("refresh");
        $this->loadPrice();

    }


    //nombre completo cliente
    public function nombreCliente(int $id)
    {
        $nombreCompleto =  sprintf("%s %s", $this->clientes->find($id)->nombre,  $this->clientes->find($id)->apellido);
        return $nombreCompleto;
    }


    public function fechaContratoFormat()
    {
        date_default_timezone_set("Europe/Madrid");
        setlocale(LC_TIME, 'es_Es.UTF-8', 'esp');
        $fecha = strtotime($this->fechaContrato);
        $formato = new IntlDateFormatter(
            'es-ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            'Europe/Madrid',
            IntlDateFormatter::GREGORIAN,
            "eeee, LLLL 10, yyyy"
        );
        return $formato->format($fecha);
    }

    

    public function loadPrice(){
        $this->total = Presupuesto::find($this->id_presupuesto)->precioFinal;
        // dd($this->total);
    }


    //Detecta si es una transferencia o no

    public function isTransferencia()
    {


        $this->isTransferencia = $this->metodoPago == $this->metodoTransferencia;
    }


    public function diasServicio()
    {
        if ($this->diaEvento === $this->diaFinal) {
            //$this->dia = $this->diaInicio;
            $this->nDias = 1;
        } else {
            $this->nDias = date_diff($this->diaEvento, $this->diaFinal)->format("%R%a");
        }
    }




    public function nombreMonitor(int $id)
    {
        $nombreCompleto =  sprintf("%s %s", $this->monitores->find($id)->nombre,  $this->monitores->find($id)->apellidos);
        return $nombreCompleto;
    }




    public function error($message)
    {

        $this->alert('error', $message,);
    }


    public function render()
    {
        return view('livewire.contratos.create-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {

        // $servicios = $this->submitServicioList();

        // if ($servicios) {

        // Validación de datos
        $validatedData = $this->validate(
            [
                "id_presupuesto" => "required",
                'metodoPago' => 'required',
                'cuentaTransferencia' => $this->isTransferencia ? 'required' : '',
                'total' => 'required',
                'responsableTratamiento' => 'required',
                'authImagen' => 'required',
                'authMenores' => 'required',
            ],
            // Mensajes de error
            [
                'metodoPago.required' => 'La contraseña es obligatoria.',
                'cuentaTransferencia.required' => 'La cuenta es obligatoria',
                'total.required' => 'El lugar es obligatorio.',
                'responsableTratamiento.required' => 'La localidad es obligatoria.',
                'authImagen.required' => 'La localidad es obligatoria.',
                'authMenores.required' => 'La localidad es obligatoria.',
            ]
        );




        // Guardar datos validados
        $contratoSave = Contrato::create(array_merge($validatedData, ["dia" => $this->fechaContrato]));


        // Alertas de guardado exitoso
        if ($contratoSave) {

            $this->alert('success', '¡Contrato registrado correctamente!', [
                'position' => 'center',
                // 'timer' => 1500,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                // 'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del usuario!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    // // Función para cuando se llama a la alerta
    // public function getListeners()
    // {
    //     return [
    //         'confirmed',
    //     ];
    // }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        // return redirect()->route('eventos.index');
        return redirect()->route('contratos.index');
    }
}
