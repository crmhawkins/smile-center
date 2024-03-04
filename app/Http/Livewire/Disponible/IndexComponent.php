<?php

namespace App\Http\Livewire\Disponible;

use App\Models\Presupuesto;
use App\Models\Servicio;
use App\Models\Articulos;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class IndexComponent extends Component
{
    public $servicios;
    public $articulos;
    public $dia;



    public function mount()
    {
        $this->servicios = Servicio::all();
        $this->articulos = Articulos::all();
        $this->dia = Carbon::now()->format('Y-m-d');
    }

    public function stock($id,$date){
        $servicioId = $id;

        $fechaEvento = $date;

        $sumaTotalStockUsado = DB::table('presupuestos')
            ->join('servicio_presupuesto', 'presupuestos.id', '=', 'servicio_presupuesto.presupuesto_id')
            ->whereRaw('? BETWEEN presupuestos.diaEvento AND presupuestos.diaFinal', [$fechaEvento])
            ->where('servicio_presupuesto.servicio_id', $servicioId)
            ->selectRaw('SUM(CASE
                WHEN servicio_presupuesto.articulo_seleccionado != 0 THEN 1
                ELSE servicio_presupuesto.num_art_indef
                END) AS total_stock_usado')
            ->value('total_stock_usado');
            // Obtener el stock total fijo del artículo
            $stockTotal = $this->articulos::where('id_categoria' == $servicioId)->count();
            dd( $stockTotal);
            $nuevaCantidadTotal = $sumaTotalStockUsado + $cantidadStockUsadoNuevoServicio;
            if ($nuevaCantidadTotal > $stockTotal) {
                $stockSeSupera = true;
            }
    }

    public function render()
    {
        return view('livewire.disponible.index-component');
    }

    public function cambiodia()
    {

    }
}
