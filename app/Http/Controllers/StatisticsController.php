<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helpers\AjaxForm;
use App\Models\User;
use App\Models\Statistics;
use App\Models\Alerts\Alert;
use App\Models\Invoices\Invoice;
use App\Models\Invoices\InvoiceConcepts;
use App\Models\Invoices\InvoiceReference;
use App\Models\Invoices\InvoiceReferenceAutoincrement;
use App\Models\Ingresos\Ingreso;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailHoliday;
use Calendar;
use DateTime;
use App\Models\Accounting\Gasto;
use App\Models\Budgets\BudgetReferenceAutoincrement;


use App\Models\Budgets\Budget;
use App\Models\Budgets\BudgetStatus;
use App\Models\Budgets\BudgetConcepts;
use App\Models\Budgets\BudgetConceptType;
use App\Models\Budgets\BudgetCustomPDF;
use App\Models\Budgets\BudgetReference;
use App\Models\Budgets\BudgetSupplierRequest;
use App\Models\Budgets\BudgetSend;
use App\Models\Presupuesto;
use Carbon\Carbon;


class StatisticsController extends Controller{
    /**
     * Mostrar Estadisticas
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	$ArrayFacturacion = array();
    	$yearsRaw = DB::table('balance_trimester')->select('year')->distinct()->get();
        $quantityTotal = array();
        $now = Carbon::now();

    	foreach ($yearsRaw as $year) {
            $quantityYear = 0;
    		$ArrayFacturacion[] = (int)$year->year;
            $all = Statistics::where('year', (int)$year->year)->get();
            foreach ($all as $balance) {
                $quantityYear += $balance->quantity;
            }
            $quantityTotal[] = (float)number_format((float)$quantityYear, 2, ',', '.');
    	}

        $billingMonthly = $this->getBillingMonthly($now->year);

        $monthsToActually = $this->getArrayMonths();

        $allArray = $this->getBillingAllRecords();

        $mes = $now->format('m');
        $year = Carbon::today()->year;
        ini_set('memory_limit', '9024M'); // or you could use 1G


        // Proyectos Activos
        $dataBudgets = $this->proyectosActivos();

         // Presupuesto Mes
         $countTotalBudgets = $this->budgets();
         $countBudgets = $dataBudgets['total'];
         $arrayBudgets = $dataBudgets['array'];

        //  // Invoices Mes
        // $dataFacturacion = $this->invoices($mes, $year);
        // $totalFacturacionMes = $dataFacturacion['total'];
        // $arrayFacturacionMes = $dataFacturacion['array'];

         // Invoices Año
        // $dataFacturacionAnno = $this->invoicesYear($year);
        // $totalFacturacionAnno = $dataFacturacionAnno['total'];
        // $arrayFacturacionAnno = $dataFacturacionAnno['array'];

        // $dataAsociados = $this->gastosAsociados($mes, $year);
        // $gastosAsociadosTotal = $dataAsociados['total'];
        // $arrayAsociadosTotal = $dataAsociados['array'];
        // $arrayAsociadosPrueba = $dataAsociados['prueba'];

        // // Gastos Comunes Mes
        // $dataGastosComunes = $this->gastosComunes($mes, $year);
        // $gastosComunesTotales = $dataGastosComunes['total'];
        // $arrayGastosComunes = $dataGastosComunes['array'];

        // $dataGastosComunesAnual = $this->gastosComunesAnual($year);
        // $gastosComunesTotalesAnual = $dataGastosComunesAnual['total'];
        // $arrayGastosComunesAnual = $dataGastosComunesAnual['array'];

        // $dataAsociadosAnual = $this->gastosAsociadosAnual($year);
        // $gastosAsociadosTotalAnual = $dataAsociadosAnual['total'];
        // $arrayAsociadosTotalAnual = $dataAsociadosAnual['array'];


    	return view('statistics.index', compact('ArrayFacturacion', 'yearsRaw', 'quantityTotal','monthsToActually', 'allArray', 'countTotalBudgets', 'countBudgets',
        'arrayBudgets','billingMonthly'));
    }

    public function proyectosActivos()
    {


        $proyectosStatus3 = Presupuesto::where('estado_id', 2)->get();
        $proyectosStatus4 = Presupuesto::where('estado_id', 4)->get();

        $arrayProyectos = [];
        foreach ($proyectosStatus3 as $item) {
            array_push($arrayProyectos, $item);
        }
        foreach ($proyectosStatus4 as $item) {
            array_push($arrayProyectos, $item);
        }

        $countBudgets = count($proyectosStatus3) + count($proyectosStatus4);

        $data = [
            'array' => $arrayProyectos,
            'total' => $countBudgets,
        ];

        return $data;
    }

    public function budgets()
    {
        $proyectosStatus3 = Presupuesto::where('estado_id', 2)->get();
        $proyectosStatus4 = Presupuesto::where('estado_id', 4)->get();
        $proyectosStatus5 = Presupuesto::where('estado_id', 5)->get();

        $countTotalBudgets = 0;
        foreach ($proyectosStatus3 as $item) {
            $countTotalBudgets += $item->servicios()->sum('precio');
        }
        foreach ($proyectosStatus5 as $item) {
            $countTotalBudgets += $item->servicios()->sum('precio');
        }
        foreach ($proyectosStatus4 as $item) {
            $countTotalBudgets += $item->servicios()->sum('precio');
        }

        return $countTotalBudgets;
    }

    // public function invoicesYear($year)
    // {
    //     $facturas = Invoice::whereYear('created_at', $year)->get();
    //     $facturasFiltradas = [];
    //     $totalFacturado = 0;

    //     foreach ($facturas as $factura) {
    //         if (
    //             $factura->invoice_status_id == 4 ||
    //             $factura->invoice_status_id == 3 ||
    //             $factura->invoice_status_id == 1
    //         ) {
    //             array_push($facturasFiltradas, $factura);
    //         }
    //     }

    //     foreach ($facturasFiltradas as $factura) {
    //             $totalFacturado += $factura->total;
    //         }

    //     $data = [
    //         'array' => $facturasFiltradas,
    //         'total' => $totalFacturado,
    //     ];

    //     return $data;
    // }

    // Gastos Comunes
    public function gastosComunes($mes, $year)
    {
        $gastosComunesMes = DB::table('gastos')
            ->whereMonth('date', $mes)
            ->whereYear('date', $year)
            ->where('deleted_at', null)
            ->get();

        $gastosComunesMesActual = [];
        $gastosComunesTotales = 0;

        for ($i = 0; $i < count($gastosComunesMes); $i++) {
            if ($gastosComunesMes[$i]->transfer_movement == 0 && $gastosComunesMes[$i]->deleted_at == null) {
                array_push($gastosComunesMesActual, $gastosComunesMes[$i]);
                $gastosComunesTotales += $gastosComunesMes[$i]->quantity;
            }
        }

        $data = [
            'array' => $gastosComunesMesActual,
            'total' => $gastosComunesTotales,
        ];

        return $data;
    }

    // Gastos Comunes Anual
    public function gastosComunesAnual($year)
    {
        $gastosComunesMes = DB::table('gastos')
            ->whereYear('date', $year)
            ->where('deleted_at', null)
            ->get();

        $gastosComunesMesActual = [];
        $gastosComunesTotales = 0;

        for ($i = 0; $i < count($gastosComunesMes); $i++) {
            if ($gastosComunesMes[$i]->transfer_movement == 0 && $gastosComunesMes[$i]->deleted_at == null) {
                array_push($gastosComunesMesActual, $gastosComunesMes[$i]);
                $gastosComunesTotales += $gastosComunesMes[$i]->quantity;
            }
        }

        $data = [
            'array' => $gastosComunesMesActual,
            'total' => $gastosComunesTotales,
        ];

        return $data;
    }

    // Gastos Asociados Anual

    // public function gastosAsociadosAnual($year)
    // {
    //     $gastosComunesMes = DB::table('gastos')
    //         ->whereYear('date', $year)
    //         ->get();

    //     $dataFacturacion = Invoice::whereYear('created_at', $year)->get();

    //     $gastosAsociadosArray = [];
    //     $arrayOrdenesCompra = [];
    //     $gastosAsociadosTotal = 0;

    //     foreach ($dataFacturacion as $item) {
    //         if (
    //             $item->invoice_status_id == 4 ||
    //             $item->invoice_status_id == 3
    //         ) {
    //             $budgetComparar = Budget::where(
    //                 'id',
    //                 $item->budget_id
    //             )->first();
    //             array_push($gastosAsociadosArray, $item);
    //             $cliente = Client::where('id', $budgetComparar->client_id)->first();

    //             $budgetConcep = BudgetConcepts::where(
    //                 'budget_id',
    //                 $budgetComparar->id
    //             )->get();

    //             for ($i = 0; $i < count($budgetConcep); $i++) {
    //                 if ($budgetConcep[$i]->concept_type_id == 1) {
    //                     if ($budgetConcep[$i]->purchase_price != '') {
    //                         $gastosAsociadosTotal += $budgetConcep[$i]->purchase_price;
    //                         $budgetConcep[$i]['budgetConcep'] = $budgetConcep;
    //                         $budgetConcep[$i]['budgetComparar'] = $budgetComparar;
    //                         $budgetConcep[$i]['client'] = $cliente;
    //                         $budgetConcep[$i]['idinvoices'] = $item->id;
    //                         $budgetConcep[$i]['invoice'] = $item;


    //                         array_push($arrayOrdenesCompra, $budgetConcep[$i]);
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $data = [
    //         'array' => $arrayOrdenesCompra,
    //         'total' => $gastosAsociadosTotal,
    //         'prueba' => $dataFacturacion
    //     ];

    //     return $data;
    // }

    // // Invoice
    // public function invoices($mes, $year)
    // {
    //     $facturas = Invoice::whereMonth('created_at', $mes)
    //         ->whereYear('created_at', $year)
    //         ->get();
    //     $facturasFiltradas = [];
    //     $totalFacturado = 0;

    //     foreach ($facturas as $factura) {
    //         if (
    //             $factura->invoice_status_id == 4 ||
    //             $factura->invoice_status_id == 3 ||
    //             $factura->invoice_status_id == 1
    //         ) {
    //             array_push($facturasFiltradas, $factura);
    //         }
    //     }

    //     foreach ($facturasFiltradas as $factura) {
    //             $totalFacturado += $factura->total;
    //         }

    //     $data = [
    //         'array' => $facturasFiltradas,
    //         'total' => $totalFacturado,
    //     ];

    //     return $data;
    // }

    // // Gastos Asociados
    // public function gastosAsociados($mes, $year)
    // {
    //     $gastosComunesMes = DB::table('gastos')
    //         ->whereYear('date', $year)
    //         ->get();

    //     $dataFacturacion = Invoice::whereMonth('created_at', $mes)->whereYear('created_at', $year)->get();

    //     $gastosAsociadosArray = [];
    //     $arrayOrdenesCompra = [];
    //     $gastosAsociadosTotal = 0;

    //     foreach ($dataFacturacion as $item) {
    //         if (
    //             $item->invoice_status_id == 4 ||
    //             $item->invoice_status_id == 3
    //         ) {
    //             $budgetComparar = Budget::where(
    //                 'id',
    //                 $item->budget_id
    //             )->first();
    //             array_push($gastosAsociadosArray, $item);
    //             $cliente = Client::where('id', $budgetComparar->client_id)->first();

    //             $budgetConcep = BudgetConcepts::where(
    //                 'budget_id',
    //                 $budgetComparar->id
    //             )->get();



    //             for ($i = 0; $i < count($budgetConcep); $i++) {
    //                 if ($budgetConcep[$i]->concept_type_id == 1) {
    //                     if ($budgetConcep[$i]->purchase_price != '') {
    //                         $gastosAsociadosTotal += $budgetConcep[$i]->purchase_price;
    //                         $budgetConcep[$i]['budgetConcep'] = $budgetConcep;
    //                         $budgetConcep[$i]['budgetComparar'] = $budgetComparar;
    //                         $budgetConcep[$i]['client'] = $cliente;
    //                         $budgetConcep[$i]['idinvoices'] = $item->id;
    //                         $budgetConcep[$i]['invoice'] = $item;




    //                         array_push($arrayOrdenesCompra, $budgetConcep[$i]);
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $data = [
    //         'array' => $arrayOrdenesCompra,
    //         'total' => $gastosAsociadosTotal,
    //         'prueba' => $dataFacturacion
    //     ];

    //     return $data;
    // }



    // ------------------------ Gráficos de Estadísticas Facturación ------------------------
    public function getArrayMonths(){
        $months = array();
        $num = date("n");

        for($i = 1; $i <= $num; $i++){
            $dateObj = DateTime::createFromFormat('!m', $i);
            array_push($months, $dateObj->format('F'));
        }

        return $months;
    }

    public function getArrayMonthsAll(){
        $months = array();

        for($i = 1; $i <= 12; $i++){
            $dateObj = DateTime::createFromFormat('!m', $i);
            array_push($months, $dateObj->format('F'));
        }

        return $months;
    }

    public function getBillingMonthly($year){
        // Este es el que tiene que recibir
        // $year = 2022;
        $billing = array();
        $months = $this->getArrayMonths();

        foreach ($months as $month) {
            switch ($month) {
                case 'January':
                    $billing = $this->getBillingByMonthly($billing, "A", $year);
                    break;
                case 'February':
                    $billing = $this->getBillingByMonthly($billing, "B", $year);
                    break;
                case 'March':
                    $billing = $this->getBillingByMonthly($billing, "C", $year);
                    break;
                case 'April':
                    $billing = $this->getBillingByMonthly($billing, "D", $year);
                    break;
                case 'May':
                    $billing = $this->getBillingByMonthly($billing, "E", $year);
                    break;
                case 'June':
                    $billing = $this->getBillingByMonthly($billing, "F", $year);
                    break;
                case 'July':
                    $billing = $this->getBillingByMonthly($billing, "G", $year);
                    break;
                case 'August':
                    $billing = $this->getBillingByMonthly($billing, "H", $year);
                    break;
                case 'September':
                    $billing = $this->getBillingByMonthly($billing, "I", $year);
                    break;
                case 'October':
                    $billing = $this->getBillingByMonthly($billing, "J", $year);
                    break;
                case 'November':
                    $billing = $this->getBillingByMonthly($billing, "K", $year);
                    break;
                case 'December':
                    $billing = $this->getBillingByMonthly($billing, "L", $year);
                    break;
                default:
                    break;
            }
        }
        return $billing;
    }


    // public function getGastosBillingMonthly($year){
    //     $billing = array();
    //     $months = $this->getArrayMonths();

    //     foreach ($months as $month) {
    //         switch ($month) {
    //             case 'January':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "A", $year);
    //                 break;
    //             case 'February':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "B", $year);
    //                 break;
    //             case 'March':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "C", $year);
    //                 break;
    //             case 'April':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "D", $year);
    //                 break;
    //             case 'May':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "E", $year);
    //                 break;
    //             case 'June':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "F", $year);
    //                 break;
    //             case 'July':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "G", $year);
    //                 break;
    //             case 'August':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "H", $year);
    //                 break;
    //             case 'September':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "I", $year);
    //                 break;
    //             case 'October':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "J", $year);
    //                 break;
    //             case 'November':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "K", $year);
    //                 break;
    //             case 'December':
    //                 $billing = $this->getGastosBillingByMonthly($billing, "L", $year);
    //                 break;
    //             default:
    //                 break;
    //         }
    //     }
    //     return $billing;
    // }


    // public function getExpensesMonthly($year){
    //     $expenses = array();
    //     $months = $this->getArrayMonths();

    //     foreach ($months as $month) {
    //         switch ($month) {
    //             case 'January':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 1, $year);
    //                 break;
    //             case 'February':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 2, $year);
    //                 break;
    //             case 'March':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 3, $year);
    //                 break;
    //             case 'April':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 4, $year);
    //                 break;
    //             case 'May':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 5, $year);
    //                 break;
    //             case 'June':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 6, $year);
    //                 break;
    //             case 'July':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 7, $year);
    //                 break;
    //             case 'August':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 8, $year);
    //                 break;
    //             case 'September':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 9, $year);
    //                 break;
    //             case 'October':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 10, $year);
    //                 break;
    //             case 'November':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 11, $year);
    //                 break;
    //             case 'December':
    //                 $expenses = $this->getExpensesByMonthly($expenses, 12, $year);
    //                 break;
    //             default:
    //                 break;
    //         }
    //     }

    //     return $expenses;
    // }

    // public function getGastosBillingByMonthly($billing, $letter, $year){
    //     if(!$year){
    //         $year = date("Y");
    //     }
    //     if ($letter == 'A'){
    //         $mes = '01';
    //     }else if($letter == 'B'){
    //         $mes = '02';
    //     }else if($letter == 'C'){
    //         $mes = '03';
    //     }else if($letter == 'D'){
    //         $mes = '04';
    //     }else if($letter == 'E'){
    //         $mes = '05';
    //     }else if($letter == 'F'){
    //         $mes = '06';
    //     }else if($letter == 'G'){
    //         $mes = '07';
    //     }else if($letter == 'H'){
    //         $mes = '08';
    //     }else if($letter == 'I'){
    //         $mes = '09';
    //     }else if($letter == 'J'){
    //         $mes = '10';
    //     }else if($letter == 'K'){
    //         $mes = '11';
    //     }else if($letter == 'L'){
    //         $mes = '12';
    //     }

    //     $total = 0;
    //     $facturas = DB::table('gastos')->whereMonth('date','=' ,$mes)->get();

    //     foreach ($facturas as $factura) {
    //         $total += $factura->quantity;
    //     }

    //     $billing[] = number_format((float)$total, 2, '.', '');

    //     return $billing;

    // }

    public function getBillingByMonthly($billing, $letter, $year){
        if(!$year){
            $year = date("Y");
        }
        if ($letter == 'A'){
            $mes = '01';
        }else if($letter == 'B'){
            $mes = '02';
        }else if($letter == 'C'){
            $mes = '03';
        }else if($letter == 'D'){
            $mes = '04';
        }else if($letter == 'E'){
            $mes = '05';
        }else if($letter == 'F'){
            $mes = '06';
        }else if($letter == 'G'){
            $mes = '07';
        }else if($letter == 'H'){
            $mes = '08';
        }else if($letter == 'I'){
            $mes = '09';
        }else if($letter == 'J'){
            $mes = '10';
        }else if($letter == 'K'){
            $mes = '11';
        }else if($letter == 'L'){
            $mes = '12';
        }

        $total = 0;
        $facturas = Presupuesto::whereMonth('fechaEmision','=' ,$mes)->where('estado_id',5)->get();

        foreach ($facturas as $factura) {
            $total += $factura->servicios()->sum('precio');
        }
        $billing[] = number_format((float)$total, 2, '.', '');

        return $billing;

    }

    //  public function getExpensesByMonthly($expenses, $month, $year){
    //     if(!$year){
    //         $year = date("Y");
    //     }

    //     $total = 0;
    //     $gastos = Gasto::where('transfer_movement', 0)->whereMonth('date', $month)->whereYear('date', $year)->get();

    //     foreach ($gastos as $gasto) {
    //         $total += $gasto->quantity;
    //     }

    //     $expenses[] = number_format((float)$total, 2, '.', '');

    //     return $expenses;

    // }

    // ********************************** //


    public function getBillingAllRecords(){
        $yearsRaw = DB::table('balance_trimester')->select('year')->distinct()->get();
        $allArray = array();

        foreach ($yearsRaw as $year) {

            if ($year->year != "2022"){
                $all = Statistics::where('year', (int)$year->year)->pluck('quantity')->toArray();
                $allArray[$year->year] = $all;
            }
        }

        return $allArray;
    }

    public function benefit(){
        $total = array();
        $now = Carbon::now();
        $monthsToActually = $this->getArrayMonths();
        $facturacion = $this->getBillingMonthly($now->year);
        $gastos = $this->getExpensesMonthly($now->year);

        for($i = 0; $i<count($facturacion);$i++){
            $total[$i] = $facturacion[$i] - $gastos[$i];
        }

        return view('admin.benefit.index', compact('total', 'monthsToActually'));
    }

}
