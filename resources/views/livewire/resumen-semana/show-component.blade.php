<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CUADRANTE SEMANAL</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Cuadrante</a></li>
                    <li class="breadcrumb-item active">Cuadrante semanal</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    @foreach($dias as $diaIndex => $dia)
                    <div class="form-group col-md-12">
                        <h5 class="ms-3" style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">{{$dia}}</h5>
                    </div>
                    <div class="form-group col-md-12">
                        @if($eventos->where('diaEvento', $fechas[$diaIndex])->count() > 0)
                        @foreach($eventos->where('diaEvento', $fechas[$diaIndex]) as $evento)
                        <table class="table table-striped table-bordered nowrap">
                            <tr>
                                <th colspan="1">#{{$presupuestos->where('id_evento', $evento->id)->first()->nPresupuesto}}</th>
                                <td colspan="7">{{$evento->eventoNombre}}</th>
                            </tr>
                            <tr>
                                <th>{{$presupuestos->where('id_evento', $evento->id)->first()->precioFinal}} €</th>
                                <th>{{$evento->eventoNiños}} niños</th>
                                <th>{{$evento->eventoAdulto}} adultos</th>
                                <th>FOTOS?</th>
                                <th></th>
                                <th>{{$evento->eventoLugar}}</th>
                                <th></th>
                                <th>{{$evento->eventoLocalidad}}</th>

                            </tr>
                            <tr>
                                <th>Servicio</th>
                                <th>Hora de montaje</th>
                                <th>Hora de inicio</th>
                                <th>Duración</th>
                                <th>Tiempo de desmontaje</th>
                                <th>Monitor</th>
                                <th>Sueldo</th>
                                <th>Gasoil</th>
                            </tr>
                            @foreach($presupuestos->where('id_evento', $evento->id)->first()->servicios()->get() as $servicio)
                            @foreach(json_decode($servicio->pivot->id_monitores, true) as $monitoresIndex => $monitores)
                            <tr>
                                <td>{{$servicio->nombre}}</td>
                                <td>{{$servicio->pivot->hora_montaje}}</td>
                                <td>{{$servicio->pivot->hora_inicio}}</td>
                                <td>{{$servicio->pivot->tiempo}}</td>
                                <td>{{$servicio->pivot->tiempo_desmontaje}}</td>
                                <td>{{$monitores_datos->firstWhere('id', $monitores)->nombre}} {{$monitores_datos->firstWhere('id', $monitores)->apellidos}}</td>
                                <td>{{json_decode($servicio->pivot->sueldo_monitores, true)[$monitoresIndex]}} €</td>
                                <td>{{$servicio->pivot->hora_montaje}}</td>
                            </tr>
                            @endforeach
                            @endforeach
                            @foreach($presupuestos->where('id_evento', $evento->id)->first()->packs()->get() as $pack)
                            @foreach($pack->servicios()->get() as $servicioIndex => $servicio)
                            @foreach(json_decode($pack->pivot->id_monitores, true)[$servicioIndex] as $monitoresIndex => $monitores)
                            <tr>
                                <td>@if($monitoresIndex == 0) {{$servicio->nombre}} @endif</td>
                                <td>@if($evento->eventoMontaje == 1) {{json_decode($pack->pivot->horas_montaje, true)[$servicioIndex]}} @endif</td>
                                <td>{{json_decode($pack->pivot->horas_inicio, true)[$servicioIndex]}}</td>
                                <td>{{json_decode($pack->pivot->tiempos, true)[$servicioIndex]}} h</td>
                                <td>@if($evento->eventoMontaje == 1){{json_decode($pack->pivot->tiempos_desmontaje, true)[$servicioIndex]}} h @endif</td>
                                <td>{{$monitores_datos->firstWhere('id', $monitores)->nombre}} {{$monitores_datos->firstWhere('id', $monitores)->apellidos}}</td>
                                <td>{{json_decode($pack->pivot->sueldos_monitores, true)[$servicioIndex][$monitoresIndex]}} €</td>
                                <td>0 €</td>
                            </tr>
                            @endforeach
                            @endforeach
                            @endforeach
                            <tr>
                                <th colspan="7">Observaciones</th>
                                <th>Fin del servicio</th>
                            </tr>
                            <tr>
                                <th colspan="7">{{$presupuestos->where('id_evento', $evento->id)->first()->observaciones}}</th>
                                <th>Fin del servicio</th>
                            </tr>
                        </table>
                        @endforeach
                        @else
                        <h6 class="text-center">No hay eventos para este día.</h6>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card m-b-30 position-fixed">
                <div class="card-body">
                    <h5>Elige una semana para resumir</h5>
                    <div class="row">
                        <div class="col-12">
                            <input type="week" class="form-control" wire:model="semana" wire:change="cambioSemana">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
