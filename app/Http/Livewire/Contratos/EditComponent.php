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

class EditComponent extends Component
{

    use LivewireAlert;

    public $empresa;
    public $identificador;
    public $contrato;

    public $presupuestos;
    public $presupuesto;
    public $id_presupuesto;

    //contrato Servicios
    public $nContrato;
    public $diaEvento;
    public $observaciones = "";


    //controlador
    public bool $clienteExistente = true;
    public bool $clienteRefresh = true;


    //desplegables
    public $solicitante = null;
    public $oldSolicitante = null;

    //cliente
    public $id_cliente;
    public $trato = null;
    public $nombre;
    public $apellido;
    public $tipoCalle;
    public $calle;
    public $numero;
    public $direccionAdicional1 = "";
    public $direccionAdicional2 = "";
    public $direccionAdicional3 = "";
    public $codigoPostal;
    public $ciudad;
    public $nif;
    public $tlf1;
    public $tlf2 = 0;
    public $tlf3 = 0;
    public $email1;
    public $email2 = "No";
    public $email3 = "No";
    public $confPostal = false;
    public $confEmail = false;
    public $confSms = false;

    public $clienteIsSave = false;


    // Evento
    public $eventoNombre;
    public $eventoProtagonista;
    public $eventoNiños;
    public $eventoContacto;
    public $eventoParentesco;
    public $eventoTelefono;
    public $eventoLugar;
    public $eventoLocalidad;
    public $eventoMontaje = false;
    public $diaFinal;

    public $eventoIsSave = false;


    //Monitores
    public $monitores;

    // Servicios
    public $evento;
    public $id_evento;
    public $id_monitor;
    public $id_servicio;
    public $comienzoMontaje;
    public $tiempo;
    public $horaInicio;
    public $tiempodDesmontaje;
    public $precioMonitor;
    public $costoDesplazamiento;
    public $dia;
    public $minMonitores;
    public $numMonitores;
    public $importeBase;
    public $descuentoServicio;
    public $importeServicioDesc;

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
    public $metodosPago;
    public $metodoPago;
    public $metodoTransferencia;
    public $cuentas;
    public $cuentaTransferencia;

    //Descuentos
    public $descuento = 0;
    // public $descTotal = 0;
    public $entregaDiscount;
    public $totalDiscount;

    //triggers
    public $addDiscount = false;
    public $isTransferencia = false;
    public $addPrograma = false;
    public $addCliente = false;
    public $addServicio = false;
    public $addObservaciones = false;


    public $fechaContrato;

    //Consentimiento
    public $authImagen = 0;
    public $authMenores = 0;
    public $responsableTratamiento;

    protected $listeners = ['refreshComponent' => '$refresh'];



    public function mount()
    {
        $this->servicios = Servicio::all();
        $this->clientes = Cliente::all();

        $this->empresa = Empresa::find("1");

        $this->presupuestos = Presupuesto::all();

        //Autoincrementa automaticamente el numero del contrato antes de que se cree

        $this->nContrato = Contrato::max("id") + 1;
        $this->monitores = Monitor::all();
        $this->metodosPago = MetodoPago::all();
        $this->cuentas = CuentaBancaria::all();

        $this->metodoTransferencia = $this->metodosPago->where("nombre", "Transferencia")->first()->id;

        $this->listaServicios = [];
        $this->dia = $this->diaEvento;
        $this->fechaContrato = now();

        $this->loadContrato();
        
    }

    public function loadContrato(){
        $this->contrato = Contrato::find($this->identificador);
        $this->id_presupuesto = $this->contrato->id_presupuesto;
        $this->loadPresupuesto($this->id_presupuesto);
        $this->metodoPago = $this->contrato->metodoPago;
        $this->responsableTratamiento = $this->contrato->responsableTratamiento;
        $this->authImagen = $this->contrato->authImagen;
        $this->authMenores = $this->contrato->authMenores;
    }

    public function loadPresupuesto()
    {
        $this->emit("refresh");
        $this->loadPrice();

    }

    public function loadPrice(){
        $this->total = Presupuesto::find($this->id_presupuesto)->precioFinal;
        // dd($this->total);
    }
    
    public function setupEvento($id)
    {
        $this->evento = Evento::find($id);

        $this->eventoNombre = $this->evento->eventoNombre;
        $this->eventoProtagonista = $this->evento->eventoProtagonista;
        $this->eventoNiños = $this->evento->eventoNiños;
        $this->eventoContacto = $this->evento->eventoContacto;
        $this->eventoParentesco = $this->evento->eventoParentesco;
        $this->eventoTelefono = $this->evento->eventoTelefono;
        $this->eventoLugar = $this->evento->eventoLugar;
        $this->eventoLocalidad = $this->evento->eventoLocalidad;
        $this->eventoMontaje = $this->evento->eventoMontaje;
        $this->diaFinal = $this->evento->diaFinal;
        $this->diaEvento = $this->evento->diaEvento;
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

    //Trigger para crear cliente
    public function crearCliente()
    {
        $this->addCliente = true;
    }

    public function uncheckClient()
    {
        $this->clienteIsSave = false;
    }

    public function uncheckEvent()
    {
        $this->eventoIsSave = false;
    }

    //Trigger para añadir observaciones
    public function allowObs()
    {
        $this->addObservaciones = true;
    }

    //Detecta si es una transferencia o no

    public function isTransferencia()
    {
        $this->isTransferencia = $this->metodoPago == $this->metodoTransferencia;
    }

    //Selecciona un cliente y rellena los campos con los datos del mismo
    public function selectClient($solicitante)
    {
        $cliente = $this->clientes->where("id", $solicitante)->first();
        $this->id_cliente = $solicitante;
        $this->trato = $cliente->trato;
        $this->nombre = $cliente->nombre;
        $this->apellido = $cliente->apellido;
      
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




    //Saca el nombre de un servicio
    public function servicioNombre($id)
    {
        return $this->servicios->find($id)->nombre;
    }

    //Calcula el importe Base de un servicio a partir del numero de monitores y su costo per monitor
    public function servicioImporteBase($id)
    {
        $servicio = $this->servicios->find($id);
        $importeBase = $servicio->precioBase + ($this->numMonitores * $servicio->precioMonitor);
        $this->importeBase = $importeBase;
        $this->importeServicioDesc = $importeBase;
        $this->applyServiceDiscount();
    }

    //Calcula la hora final del servicio a partir de su hora de inicio y su duracion
    public function horaFinalizacion($servicioEvento)
    {
        $hora = date("H:i:s", strtotime("$servicioEvento[horaInicio] + $servicioEvento[tiempo] hours"));
        // $hora = $servicioEvento->horaInicio->modify("+$servicioEvento->tiempo hours");
        return $hora;
    }

    //Calcula y aplica el descuento de un servicio
    public function applyServiceDiscount()
    {
        $importeBase = $this->importeBase;
        $descuentoPC = abs($this->descuentoServicio) / 100;
        $descuento = $importeBase * $descuentoPC;

        $this->importeServicioDesc = $importeBase - $descuento;
    }

    //Rellena los valores por defecto de un servicio a la hora de añadirlo
    public function setDefaultServicios($id)
    {
        $this->servicioMonitores($id);
        $this->servicioImporteBase($id);
        $this->descuentoServicio = 0;
    }

    //Saca el numero minimo de monitores y lo establece como valor por defecto del campo
    public function servicioMonitores($id)
    {
        $this->minMonitores = $this->servicios->find($id)->minMonitor;
        $this->numMonitores = $this->servicios->find($id)->minMonitor;
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
        return view('livewire.contratos.edit-component');
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
            $contrato = Contrato::find($this->identificador);
            $contratoSave = $contrato->update(array_merge($validatedData, ["dia" => $this->fechaContrato]));


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
        // } else {
        //     $this->alert('error', 'Se han insertado ' . count($servicios) . ' servicios', [
        //         // 'showConfirmButton' => true,
        //         //'onConfirmed' => 'confirmed',
        //         //'confirmButtonText' => 'ok',
        //         'timerProgressBar' => true,
        //     ]);
        // }
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
        // return redirect()->route('eventos.index');
        return redirect()->route('contratos.index');
    }
}
