<?php

namespace App\Http\Controllers;

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
        $presupuestos = Presupuesto::where('estado', 'Aceptado')->orWhere('estado', 'Pendiente')->orderBy('fechaEmision', 'ASC')->get();
        $categorias = TipoEvento::all();

        $inicioSemana = Carbon::now()->startOfWeek();  // Lunes de esta semana
        $finSemana = Carbon::now()->endOfWeek();  // Domingo de esta semana
        $inicioMes = Carbon::now()->startOfMonth()->startOfWeek();  // Lunes de esta semana
        $finMes = Carbon::now()->endOfMonth()->endOfWeek();  // Domingo de esta semana
        $inicioMesPasado = Carbon::now()->startOfMonth()->startOfWeek()->subMonth();  // Lunes de esta semana
        $finMesPasado = Carbon::now()->endofMonth()->endofWeek()->subMonth();  // Domingo de esta semana
        $ingresos_mensuales = (float) ($presupuestos->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('precioFinal') - $presupuestos->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('adelanto'));
        $ingresos_mensuales_pasado = (float) ($presupuestos->whereBetween('fechaEmision', [$inicioMesPasado, $finMesPasado])->sum('precioFinal') - $presupuestos->whereBetween('fechaEmision', [$inicioMesPasado, $finMesPasado])->sum('adelanto'));
        $porcentaje_ingresos_mensuales = round(($ingresos_mensuales / $ingresos_mensuales_pasado) * 100);
        $pendiente = (float) ($presupuestos->where('estado', '!=', 'Facturado')->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('precioFinal') - $presupuestos->where('estado', '!=', 'Facturado')->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('adelanto'));

        $user = $request->user();
        $eventos = Evento::whereBetween('diaEvento', [$inicioSemana, $finSemana])->orderBy('diaEvento', 'ASC')->get();
        $presupuestosMes = Presupuesto::where('estado', 'Facturado')->whereBetween('fechaEmision', [$inicioMes, $finMes])->get();
        $ingresoMensual = $presupuestosMes->pluck('precioFinal')->sum();
        $gastosMensual = 0;

        $sumaPacks = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->packs->flatMap(function ($pack) {
                    return json_decode($pack->pivot->sueldos_monitores, true);  // Asumiendo que "sueldos" es el nombre de la columna JSON en la tabla pivot
                });
            })
            ->flatten(1)
            ->sum();

        // Parte 2: Servicios
        $sumaServicios = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->servicios->pluck('pivot.sueldo_monitores');  // Asumiendo que "sueldos" es el nombre de la columna en la tabla pivot
            })
            ->map(function ($sueldo) {
                return (int) $sueldo;  // Convierte el string a un integer
            })
            ->sum();

        $salario_monitores = $sumaPacks + $sumaServicios;

        $sumaPacks = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->packs->flatMap(function ($pack) {
                    return json_decode($pack->pivot->pagos_pendientes, true);  // Asumiendo que "sueldos" es el nombre de la columna JSON en la tabla pivot
                });
            })
            ->flatten(1)
            ->sum();

        // Parte 2: Servicios
        $sumaServicios = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->servicios->pluck('pivot.pago_pendiente');  // Asumiendo que "sueldos" es el nombre de la columna en la tabla pivot
            })
            ->map(function ($sueldo) {
                return (int) $sueldo;  // Convierte el string a un integer
            })
            ->sum();

        $pte_pago_monitores = $sumaPacks + $sumaServicios;

        $sumaPacks = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->packs->flatMap(function ($pack) {
                    return json_decode($pack->pivot->gastos_gasoil, true);  // Asumiendo que "sueldos" es el nombre de la columna JSON en la tabla pivot
                });
            })
            ->flatten(1)
            ->sum();

        // Parte 2: Servicios
        $sumaServicios = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->servicios->pluck('pivot.gasto_gasoil');  // Asumiendo que "sueldos" es el nombre de la columna en la tabla pivot
            })
            ->map(function ($sueldo) {
                return (int) $sueldo;  // Convierte el string a un integer
            })
            ->sum();

        $gastos_gasoil = $sumaPacks + $sumaServicios;

        $sumaPacks = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->packs->flatMap(function ($pack) {
                    return json_decode($pack->pivot->gastos_gasoil, true);  // Asumiendo que "sueldos" es el nombre de la columna JSON en la tabla pivot
                });
            })
            ->flatten(1)
            ->sum();

        // Parte 2: Servicios
        $sumaServicios = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->servicios->pluck('pivot.gasto_gasoil');  // Asumiendo que "sueldos" es el nombre de la columna en la tabla pivot
            })
            ->map(function ($sueldo) {
                return (int) $sueldo;  // Convierte el string a un integer
            })
            ->sum();

        $seguros_sociales = $sumaPacks + $sumaServicios;

        $sumaPacks = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->packs->flatMap(function ($pack) {
                    return json_decode($pack->pivot->gastos_gasoil, true);  // Asumiendo que "sueldos" es el nombre de la columna JSON en la tabla pivot
                });
            })
            ->flatten(1)
            ->sum();

        // Parte 2: Servicios
        $sumaServicios = $presupuestos
            ->whereBetween('fechaEmision', [$inicioMes, $finMes])
            ->flatMap(function ($presupuesto) {
                return $presupuesto->servicios->pluck('pivot.gasto_gasoil');  // Asumiendo que "sueldos" es el nombre de la columna en la tabla pivot
            })
            ->map(function ($sueldo) {
                return (int) $sueldo;  // Convierte el string a un integer
            })
            ->sum();

        $material_fungible = $sumaPacks + $sumaServicios;

        $total_gastos = $salario_monitores + $gastos_gasoil + $seguros_sociales + $material_fungible;
        $otros_gastos = Gastos::select('tipo_gasto', DB::raw('SUM(cuantia) as total'))->groupBy('tipo_gasto')->whereBetween('date', [$inicioMes, $finMes])->get();
        $otros_gastos_total = $otros_gastos->pluck('total')->sum();

        $pendiente_pagar = $pte_pago_monitores + $pendiente;


        return view('home', compact('user', 'presupuestos', 'categorias', 'porcentaje_ingresos_mensuales', 'eventos', 'ingresoMensual', 'gastosMensual', 'ingresos_mensuales', 'otros_gastos_total','pendiente_pagar'));
    }
}
