<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\TipoEvento;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Gastos;
use App\Models\Presupuesto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $presupuestos = Presupuesto::orderBy('fechaEmision', 'ASC')->get();
        $presupuestosPendientes = Presupuesto::whereIn('estado_id', [1, 2, 3])->orderBy('fechaEmision', 'ASC')->get();
        $presupuestosAceptados = Presupuesto::where('estado_id', '4')->orderBy('fechaEmision', 'ASC')->get();

        $inicioSemana = Carbon::now()->startOfWeek();  // Lunes de esta semana
        $finSemana = Carbon::now()->endOfWeek();  // Domingo de esta semana
        $inicioMes = Carbon::now()->startOfMonth()->startOfWeek();  // Lunes de esta semana
        $finMes = Carbon::now()->endOfMonth()->endOfWeek();  // Domingo de esta semana
        $inicioMesPasado = Carbon::now()->startOfMonth()->startOfWeek()->subMonth();  // Lunes de esta semana
        $finMesPasado = Carbon::now()->endofMonth()->endofWeek()->subMonth();  // Domingo de esta semana
        $ingresos_mensuales = (float) ($presupuestos->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('precioFinal') - $presupuestos->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('adelanto'));
        $ingresos_mensuales_pasado = (float) ($presupuestos->whereBetween('fechaEmision', [$inicioMesPasado, $finMesPasado])->sum('precioFinal') - $presupuestos->whereBetween('fechaEmision', [$inicioMesPasado, $finMesPasado])->sum('adelanto'));
        $porcentaje_ingresos_mensuales = $ingresos_mensuales_pasado > 0 ? round(($ingresos_mensuales / $ingresos_mensuales_pasado) * 100) : 0;
        $pendiente = (float) ($presupuestos->where('estado', '!=', 'Facturado')->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('precioFinal') - $presupuestos->where('estado', '!=', 'Facturado')->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('adelanto'));

        $user = $request->user();
        $presupuestosMes = Presupuesto::whereBetween('fechaEmision', [$inicioMes, $finMes])->get();

        $gastos_caja = Caja::whereBetween('fecha', [$inicioSemana, $finSemana])->where('tipo_movimiento', 'Gasto')->sum('importe');
        $ingresos_caja = Caja::whereBetween('fecha', [$inicioSemana, $finSemana])->where('tipo_movimiento', 'Ingreso')->sum('importe');
        $resultados_caja = $ingresos_caja - $gastos_caja;

        return view('home', compact('user', 'presupuestosAceptados','presupuestosPendientes',  'porcentaje_ingresos_mensuales',  'ingresos_mensuales', 'ingresos_caja', 'gastos_caja', 'resultados_caja'));
    }
}
