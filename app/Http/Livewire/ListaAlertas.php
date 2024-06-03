<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Alertas;
use Illuminate\Support\Facades\Auth;

class ListaAlertas extends Component
{

    public $alertas;

    public function mount()
    {
        $this->alertas = Alertas::where('estado_id',1)->get();

    }

    public function render()
    {
        return view('livewire.lista-alertas');
    }

    public function accion( $alertaId)
    {
        $alerta = Alertas::findOrFail($alertaId);
        $alerta->update(['estado_id' => 2]);
        $this->alertas = Alertas::where('estado_id',1)->get();

        // switch ($tipo_id) {
        //     case 1:
        //         $this->alertas = Alertas::where('estado_id',1)->get();
        //         break;

        //     case 2:
        //         $this->alertas = Alertas::where('estado_id',1)->get();
        //         break;
        //     case 3:
        //         $this->alertas = Alertas::where('estado_id',1)->get();

        //         break;
        //     case 4:
        //         $this->alertas = Alertas::where('estado_id',1)->get();

        //         break;
        //     case 5:
        //         $this->alertas = Alertas::where('estado_id',1)->get();

        //         break;
        //     case 6:
        //         $this->alertas = Alertas::where('estado_id',1)->get();

        //         break;
        //     case 7:
        //         $this->alertas = Alertas::where('estado_id',1)->get();

        //         break;
        //     default:
        //     $this->alertas = Alertas::where('estado_id',1)->get();

        //     break;
        // }
    }
}



