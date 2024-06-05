@extends('layouts.app')

@section('title', 'Crear Newsletter')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<!-- Favicon -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.4.2/morris.css" rel="stylesheet" type="text/css" />

    <!-- Toggles CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toggles/2.0.4/toggles.css" rel="stylesheet" type="text/css">
    <link href=" {{ asset('assets/estadisticas/vendors/jquery-toggles/css/themes/toggles-light.css')}} " rel="stylesheet" type="text/css">
	<!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<!-- ======= END MAIN STYLES ======= -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    @media (min-width: 576px){

        .modal-dialog {
            max-width: 90% !important;
        }

    }

    .buttons_meses {
        border: 1px solid lightgray;
        border-radius: 10px;
        padding: 0 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }
    .buttons_meses:hover {
        background-color: gray;
        color: white !important;
    }
    .color-col {
        background-color: #F6F6F6;
    }
    ul.nav.nav-tabs.custom-item li {
    padding: 1rem;
}
ul.nav.nav-tabs.custom-item a {
    padding: 0.3rem 1rem;
    background-color: red;
    color: white;
    transition: all 0.5s ease-in-out;
}
ul.nav.nav-tabs.custom-item a:hover {
    background-color: white;
    color: red;
}
    </style>
<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">ESTADISTICAS <?php echo(date("Y")); ?></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Estadisticas</a></li>
                    <li class="breadcrumb-item active">Todos las citas</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row row-deck">
        <div class="col-lg-6">
            <!-- Bars Chart -->
            <div class="block">
                <div class="block-header">
                    <h3 class="block-title">Facturación anual</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <div class="py-3">
                        <!-- Bars Chart Container -->
                        <canvas id="js-chartjs-bars-my"></canvas>
                    </div>
                </div>
            </div>
            <!-- END Bars Chart -->
        </div>
         <div class="col-lg-6">
            <!-- Bars Chart -->
            <div class="block">
                <div class="block-header">
                    <h3 class="block-title">Facturación Mensual de este año</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <div class="py-3">
                        <!-- Bars Chart Container -->
                        <canvas id="facturacion-mensual"></canvas>
                    </div>
                </div>
            </div>
            <!-- END Bars Chart -->
        </div>
        <div class="col-lg-12">
            <!-- Bars Chart -->
            <div class="block">
                <div class="block-header">
                    <h3 class="block-title">Facturación Mensual de todos los años</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <div class="py-3">
                        <!-- Bars Chart Container -->
                        <canvas id="facturacion-all-monthly"></canvas>
                    </div>
                </div>
            </div>
            <!-- END Bars Chart -->
        </div>
    </div>

    <!-- Datos Empresa -->
   <!-- Datos Empresa -->
   <div class="col-xl-12">
                        <div class="hk-row">
                            <h2 class="col-12">Datos Anuales </h2>
                            <br>
                            <!-- Datos Anuales -->
                            <div class="d-flex justify-content-around">
                                <div class="col-lg-3 col-sm-6">
                                    <div class="card card-sm" data-toggle="modal" data-target="#exampleModalCenter" style="cursor:pointer;">
                                        <div class="card-body">
                                            <!-- Proyectos activos -->
                                            <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Proyectos Activos</span>
                                            <div class="d-flex align-items-center justify-content-between position-relative">
                                                <div>
                                                    <span class="d-block display-5 font-weight-400 text-dark">{{$countBudgets}}+</span>
                                                </div>
                                                <div class="r-0">
                                                    <span id="pie_chart_1" class="d-flex easy-pie-chart" data-percent="{{$countBudgets}}">
                                                        <span class="percent head-font">{{$countBudgets}}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Presupuestos Activos</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table style="width: 100%;">
                                                        <tr>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Referencia</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Cliente </th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Estado</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Fecha Creacion</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Importe</th>

                                                        </tr>
                                                        @foreach($arrayBudgets as $item)
                                                        <tr>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->paciente()->first()->nombre}} {{$item->paciente()->first()->apellido}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->estado()->first()->estado}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->created_at}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->servicios()->sum('precio')}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Presupuestos -->
                                <div class="col-lg-3 col-sm-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Presupuestos</span>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <span class="d-block text-right">
                                                        <span class="display-5 font-weight-400 text-dark">€ <span class="counter-anim">{{$countTotalBudgets}}</span></span>
                                                    </span>
                                                </div>
                                                <div class="r-0">
                                                    <span id="pie_chart_2" class="d-flex easy-pie-chart" data-percent="75">
                                                        <span class="percent head-font">{{$countTotalBudgets}}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Facturación Anual -->
                            {{-- <div class="col-lg-3 col-sm-6">
								<div class="card card-sm" data-toggle="modal" data-target="#ModalFacturacionanual" style="cursor:pointer;">
									<div class="card-body">
										<span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Facturación Anual</span>
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<span class="d-block">
													<span class="display-5 font-weight-400 text-dark">€ {{$totalFacturacionAnno}}</span>
												</span>
											</div>
											<div>
												<span class="text-success font-12 font-weight-600">+0%</span>
											</div>
										</div>
									</div>
								</div> --}}
                                <!-- Modal -->
                                {{-- <div class="modal fade" id="ModalFacturacionanual" tabindex="-1" role="dialog" aria-labelledby="ModalFacturacionanual" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Facturacion Mes Actual</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table style="width: 100%;">
                                                        <tr>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Referencia</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Cliente </th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Concepto</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Estado</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Campaña</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Fecha Creacion</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Importe</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Beneficio</th>

                                                        </tr>
                                                        <?php
                                                            $sumaColumna = 0
                                                            ?>
                                                        @foreach($arrayFacturacionAnno as $item)
                                                        <tr>
                                                            <?php
                                                            $sumaColumna += $item->total;
                                                            ?>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->reference}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->client_id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->concept}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->invoice_status_id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->project_id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->created_at}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->total}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">Total: </td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$sumaColumna}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <!-- <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                            </div> --}}

                            {{-- <!-- Beneficios Anual -->
                            <div class="col-lg-3 col-sm-6">
								<div class="card card-sm">
									<div class="card-body">
										<span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Beneficios Anual </span>
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<span class="d-block">

												<span class="display-5 font-weight-400 text-dark">{{$totalFacturacionAnno - $gastosComunesTotalesAnual - $gastosAsociadosTotalAnual}}</span>

											</div>
											<div>
												<span class="text-danger font-12 font-weight-600">0%</span>
											</div>
										</div>
									</div>
								</div>
							</div>

                            <!-- Gastos Comunes Anual -->
                            <div class="col-lg-3 col-sm-6">
								<div class="card card-sm" data-toggle="modal" data-target="#ModalGastosAsociados" style="cursor:pointer;">
									<div class="card-body">
										<span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Gastos Comunes Anual </span>
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<span class="d-block">
													<span class="display-5 font-weight-400 text-dark">{{$gastosComunesTotalesAnual}}</span>
												</span>
											</div>
											<div>
												<span class="text-danger font-12 font-weight-600">0%</span>
											</div>
										</div>
									</div>
								</div>
                                <!-- Modal -->
                                <div class="modal fade" id="ModalGastosAsociados" tabindex="-1" role="dialog" aria-labelledby="ModalGastosAsociados" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Gatos Comunes Anual</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table style="width: 100%;">
                                                        <tr>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Referencia</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Cliente </th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Concepto</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Option number</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Campaña</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Fecha Creacion</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Importe</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Beneficio</th>

                                                        </tr>
                                                        <?php
                                                            $sumaColumnaGastosAsociadosAnual = 0
                                                            ?>
                                                        @foreach($arrayGastosComunesAnual as $item)
                                                        <tr>
                                                            <?php
                                                            $sumaColumnaGastosAsociadosAnual += $item->quantity;
                                                            ?>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->title}}</td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->state}}</td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->date}}</td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->quantity}}</td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                       </tr>
                                                       @endforeach
                                                       <tr>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;">Total: </td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$sumaColumnaGastosAsociadosAnual}}</td>
                                                           <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                       </tr>
                                                    </table>
                                                </div>
                                                <!-- <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>

                             </div>
                             <!-- Gastos Asociados Anual -->
                             <div class="col-lg-3 col-sm-6">
								<div class="card card-sm" data-toggle="modal" data-target="#ModalGastosAsociados" style="cursor:pointer;">
									<div class="card-body">
										<span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Gastos Asociados Anual </span>
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<span class="d-block">
													<span class="display-5 font-weight-400 text-dark">{{$gastosAsociadosTotalAnual}}</span>
												</span>
											</div>
											<div>
												<span class="text-danger font-12 font-weight-600">0%</span>
											</div>
										</div>
									</div>
								</div>
                            </div>

                            <!-- Datos Mes -->
                            <h2 class="col-12">Datos Mes </h2>
                            <br>

                            <!-- Facturación Mes -->
                            <div class="col-lg-3 col-sm-6">
								<div class="card card-sm" data-toggle="modal" data-target="#ModalFacturacion" style="cursor:pointer;">
									<div class="card-body">
										<span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Facturación Mes</span>
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<span class="d-block">
													<span class="display-5 font-weight-400 text-dark">€ {{$totalFacturacionMes}}</span>
												</span>
											</div>
											<div>
												<span class="text-success font-12 font-weight-600">+0%</span>
											</div>
										</div>
									</div>
								</div>
                                <!-- Modal -->
                                <div class="modal fade" id="ModalFacturacion" tabindex="-1" role="dialog" aria-labelledby="ModalFacturacion" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Facturacion Mes Actual</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table style="width: 100%;">
                                                        <tr>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Referencia</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Cliente </th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Concepto</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Estado</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Campaña</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Fecha Creacion</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Importe</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Beneficio</th>

                                                        </tr>
                                                        <?php
                                                            $sumaColumna = 0
                                                            ?>
                                                        @foreach($arrayFacturacionMes as $item)
                                                        <tr>
                                                            <?php
                                                            $sumaColumna += $item->total;
                                                            ?>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->reference}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->client_id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->concept}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->invoice_status_id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->project_id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->created_at}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->total}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">Total: </td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$sumaColumna}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <!-- <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
							</div>

                            <!-- Beneficios Mes -->
                            <div class="col-lg-3 col-sm-6">
								<div class="card card-sm">
									<div class="card-body">
										<span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Beneficios Mes </span>
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<span class="d-block">

												<span class="display-5 font-weight-400 text-dark">{{$totalFacturacionMes - $gastosComunesTotales - $gastosAsociadosTotal}}</span>

											</div>
											<div>
												<span class="text-danger font-12 font-weight-600">0%</span>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <!-- Gastos Comunes Mes -->
                            <div class="col-lg-3 col-sm-6">
								<div class="card card-sm" data-toggle="modal" data-target="#ModalGastosComunes" style="cursor:pointer;">
									<div class="card-body">
										<span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Gastos Comunes Mes </span>
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<span class="d-block">
													<span class="display-5 font-weight-400 text-dark">{{$gastosComunesTotales}}</span>
												</span>
											</div>
											<div>
												<span class="text-danger font-12 font-weight-600">0%</span>
											</div>
										</div>
									</div>
								</div>
                                <!-- Modal -->
                                <div class="modal fade" id="ModalGastosComunes" tabindex="-1" role="dialog" aria-labelledby="ModalGastosComunes" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Gatos Comunes Mes Actual</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table style="width: 100%;">
                                                        <tr>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Referencia</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Cliente </th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Concepto</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Estado</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Campaña</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Fecha Creacion</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Importe</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Beneficio</th>

                                                        </tr>
                                                        <?php
                                                            $sumaColumnaGastosComunes = 0
                                                            ?>
                                                        @foreach($arrayGastosComunes as $item)
                                                        <tr>
                                                            <?php
                                                            $sumaColumnaGastosComunes += $item->quantity;
                                                            ?>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->title}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->state}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->date}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->quantity}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">Total: </td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$sumaColumnaGastosComunes}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <!-- <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
							</div>
                            <!-- Gastos Asociados Mes -->
                            <div class="col-lg-3 col-sm-6">
								<div class="card card-sm" data-toggle="modal" data-target="#ModalGastosAsociadosMes" style="cursor:pointer;">
									<div class="card-body">
										<span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Gastos Asociados Mes </span>
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<span class="d-block">
													<span class="display-5 font-weight-400 text-dark">{{$gastosAsociadosTotal}}</span>
												</span>
											</div>
											<div>
												<span class="text-danger font-12 font-weight-600">0%</span>
											</div>
										</div>
									</div>
								</div>
                                 <!-- Modal -->
                                 <div class="modal fade" id="ModalGastosAsociadosMes" tabindex="-1" role="dialog" aria-labelledby="ModalGastosAsociadosMes" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Gatos Asociados Mes Actual</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table style="width: 100%;">
                                                        <tr>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Referencia</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">ID Concepto </th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Cliente </th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Concepto</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Inovice ID</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Inovice status</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Fecha Creacion</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Importe</th>
                                                            <th style="border: 2px solid lightsteelblue; padding: 0.3rem; color: white; background-color: dodgerblue; font-weight: bold;">Beneficio</th>

                                                        </tr>
                                                        <?php
                                                            $sumaColumnaGastosAsociados = 0
                                                            ?>
                                                        @foreach($arrayAsociadosTotal as $item)
                                                        <tr>
                                                            <?php
                                                            $sumaColumnaGastosAsociados += $item->total;
                                                            ?>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->budgetComparar->id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->client->name}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->concept}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->idinvoices}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->invoice->invoice_status_id}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->created_at}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$item->total}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">Total: </td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;">{{$sumaColumnaGastosAsociados}}</td>
                                                            <td style="padding: 0.3rem; border: 1px solid lightgray;"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <!-- <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
							</div>
						</div> --}}






         </div>
    </div>
</div>


@section('scripts')

<!-- Toggles JavaScript -->
<script src="https://crm.hawkins.es/estadisticas/vendors/jquery-toggles/toggles.min.js"></script>
<script src="https://crm.hawkins.es/estadisticas/dist/js/toggle-data.js"></script>

<!-- Toastr JS -->
<script src="https://crm.hawkins.es/estadisticas/vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>

<!-- Easy pie chart JS -->
<script src="https://crm.hawkins.es/estadisticas/vendors/easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>


<!-- Init JavaScript -->
<script src="https://crm.hawkins.es/estadisticas/dist/js/init.js"></script>
<script src="https://crm.hawkins.es/estadisticas/dist/js/dashboard2-data.js"></script>

<script>

    	facturacionAnual();

        facturacionMensual();

        facturacionMensalAll();

        function facturacionAnual(){
            var labels = @json($ArrayFacturacion);
            var quantityYears = @json($quantityTotal);

            $( document ).ready(function() {
                var ctx = document.getElementById("js-chartjs-bars-my").getContext("2d");
                var data = {
                    labels: labels,
                    datasets: [
                        {
                            label: "Facturacion",
                            data: quantityYears,
                        },
                    ]
                };

                var myBarChart = new Chart(ctx, {
                    type: 'line',
                    data: data

                });
            });
        }

        function facturacionMensual(){
            var labels = @json($monthsToActually);
            var quantityYears = @json($billingMonthly);
            console.log(quantityYears);

            $( document ).ready(function() {
                var ctx = document.getElementById("facturacion-mensual").getContext("2d");
                var data = {
                    labels: labels,
                    datasets: [
                        {
                            label: "Facturacion",
                            data: quantityYears,
                        },
                    ]
                };

                var myBarChart = new Chart(ctx, {
                    type: 'line',
                    data: data

                });
            });
        }

        function facturacionMensalAll(){
            let billing = @json($allArray);
            console.log(billing);
            var quantityYears = @json($billingMonthly);

            let arrayAnoActual = [];

            var y = new Date().getFullYear();

            for (let i = 0; i < quantityYears.length; i++) {
                parseInt(quantityYears[i]);
                arrayAnoActual.push(parseInt(quantityYears[i]));
            }

            y = `${y}`;
            console.log(y);
            let billingActual = @json($billingMonthly);
            billing = {
                [y]: arrayAnoActual,
                ...billing

            }
            console.log(billing);
            <?php $y = (date("Y")); ?>

            $( document ).ready(function() {
                var ctx = document.getElementById("facturacion-all-monthly").getContext("2d");
                var data = {
                    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    datasets: [
                        {
                            label: "Facturacion <?php echo ($y-11) ?>",
                            data: billing[y-11],
                            backgroundColor: "#0493B0",
                            borderColor: "#0493B0",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-10) ?>",
                            data: billing[y-10],
                            backgroundColor: "#49D281",
                            borderColor: "#49D281",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-9) ?>",
                            data: billing[y-9],
                            backgroundColor: "#DED329",
                            borderColor: "#DED329",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-8) ?>",
                            data: billing[y-8],
                            backgroundColor: "#2963DE",
                            borderColor: "#2963DE",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-7) ?>",
                            data: billing[y-7],
                            backgroundColor: "#E32B2B",
                            borderColor: "#E32B2B",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-6) ?>",
                            data: billing[y-6],
                            backgroundColor: "#0C179E",
                            borderColor: "#0C179E",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-5) ?>",
                            data: billing[y-5],
                            backgroundColor: "#0FD58A",
                            borderColor: "#0FD58A",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-4) ?>",
                            data: billing[y-4],
                            backgroundColor: "#D5900F",
                            borderColor: "#D5900F",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-3) ?>",
                            data: billing[y-3],
                            backgroundColor: "#B4B4B4",
                            borderColor: "#B4B4B4",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-2) ?>",
                            data: billing[y-2],
                            backgroundColor: "#00FFC5",
                            borderColor: "#00FFC5",
                            type: 'line',
                            fill: false,
                        },
                        {
                            label: "Facturacion <?php echo ($y-1) ?>",
                            data: billing[y-1],
                            backgroundColor: "#FF0087",
                            borderColor: "#FF0087",
                            borderWidth: 5,
                            type: 'line',
                            fill: false,
                        },{
                            label: "Facturacion <?php echo ($y) ?>",
                            data: billingActual,
                            backgroundColor: "#8809eb",
                            borderColor: "#8809eb",
                            borderWidth: 5,
                            type: 'line',
                            fill: false,
                        },

                    ]
                };

                var myBarChart = new Chart(ctx, {
                    type: 'line',
                    data: data

                });
            });
        }

    </script>

@endsection
@endsection
