<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <?php

    use Carbon\Carbon;
    ?>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">AGENDA</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Agenda</a></li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    @foreach ($dias as $diaIndex => $dia)
                        <div class="form-group col-md-12">
                            <h5 class="ms-3"
                                style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">
                                {{ $dia }}</h5>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-row">
                                @if ($eventos->where('diaEvento', $fechas[$diaIndex])->count() > 0)
                                    @foreach ($eventos->where('diaEvento', $fechas[$diaIndex]) as $evento)
                                        <div class="card col-md-4">
                                            <h5 class="card-header">
                                                (#{{ $presupuestos->where('id_evento', $evento->id)->first()->nPresupuesto }})
                                                {{ $categorias->find($evento->eventoNombre)->nombre }} -
                                                {{ $this->getCliente($evento->id) }}
                                            </h5>
                                            <div class="card-body border rounded">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <div class="row">
                                                            @if ($presupuestos->where('id_evento', $evento->id)->count() > 0)
                                                                @if ($servicios_presupuesto->where('presupuesto_id', $presupuestos->where('id_evento', $evento->id)->first()->id)->count() > 0)
                                                                    @foreach ($servicios_presupuesto->where('presupuesto_id', $presupuestos->where('id_evento', $evento->id)->first()->id) as $servicioIndex => $itemServicio)
                                                                        <div class="col-md-12 text-center"
                                                                        @if($servicioIndex == 0) style="margin-top: -20px !important;" @endif >                                                                            <label for="adelantoResumen"
                                                                                class="col-sm-12 col-form-label">Servicio</label>
                                                                            <input type="text" id="adelantoResumen"
                                                                                class="form-control text-center"
                                                                                value="{{ $this->getNombreServicio($itemServicio->id) }}"
                                                                                disabled>
                                                                        </div>
                                                                        @for ($i = 0; $i < $itemServicio->numero_monitores; $i++)
                                                                            <div class="col-md-4 mt-1">
                                                                                <select class="form-control text-center"
                                                                                    wire:model="datos_servicio.{{ $itemServicio->presupuesto_id }}.{{ $itemServicio->servicio_id }}.id_monitores.{{ $i }}"
                                                                                    name="servicio_seleccionado"
                                                                                    wire:change.debounce.500ms="cambioMonitorServicio({{ $itemServicio->presupuesto_id }}, {{ $itemServicio->servicio_id }})">
                                                                                    <option value="0">Selecciona un
                                                                                        monitor.</option>
                                                                                    @foreach ($monitores as $keys => $monitor)
                                                                                        <option class="dropdown-item"
                                                                                            value="{{ $monitor->id }}">
                                                                                            {{ $monitor->nombre }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </Select>
                                                                            </div>
                                                                            <div class="col-md-4 mt-1">
                                                                                <input type="number"
                                                                                    wire:model="datos_servicio.{{ $itemServicio->presupuesto_id }}.{{ $itemServicio->servicio_id }}.sueldo_monitores.{{ $i }}"
                                                                                    wire:change.debounce.500ms="cambioMonitorServicio({{ $itemServicio->presupuesto_id }}, {{ $itemServicio->servicio_id }})"
                                                                                    class="form-control text-center"
                                                                                    placeholder="Sueldo">
                                                                            </div>
                                                                            <div class="col-md-4 mt-1">
                                                                                <input type="number"
                                                                                    wire:model="datos_servicio.{{ $itemServicio->presupuesto_id }}.{{ $itemServicio->servicio_id }}.pago_pendiente.{{ $i }}"
                                                                                    wire:change.debounce.500ms="cambioMonitorServicio({{ $itemServicio->presupuesto_id }}, {{ $itemServicio->servicio_id }})"
                                                                                    class="form-control text-center"
                                                                                    placeholder="Pendiente">
                                                                            </div>
                                                                        @endfor
                                                                    @endforeach
                                                                @endif
                                                                @if (
                                                                    $packs_presupuesto->where('presupuesto_id', $presupuestos->where('id_evento', $evento->id)->first()->id)->count() >
                                                                        0)
                                                                    @foreach ($packs_presupuesto->where('presupuesto_id', $presupuestos->where('id_evento', $evento->id)->first()->id) as $packIndex => $itemPack)
                                                                        <div class="col-md-12 text-center"
                                                                            @if($packIndex == 0) style="margin-top: -20px !important;" @endif>
                                                                            <label for="adelantoResumen"
                                                                                class="col-sm-12 col-form-label">Pack</label>
                                                                            <input type="text" id="adelantoResumen"
                                                                                class="form-control text-center"
                                                                                value="{{ $this->getNombrePack($itemPack->pack_id) }}"
                                                                                disabled>
                                                                        </div>
                                                                        @foreach ($packs->where('id', $itemPack->pack_id)->first()->servicios()->get() as $servicioIndex => $itemServicio)
                                                                            <div class="col-md-12 text-center">
                                                                                <label for="adelantoResumen"
                                                                                    class="col-sm-12 col-form-label">Servicio</label>
                                                                                <input type="text"
                                                                                    id="adelantoResumen"
                                                                                    class="form-control text-center"
                                                                                    value="{{ $this->getNombreServicio($itemServicio->id) }}"
                                                                                    disabled>
                                                                            </div>
                                                                            @for ($i = 0; $i < json_decode($itemPack->numero_monitores)[$servicioIndex]; $i++)
                                                                                <div class="col-md-4 mt-1">
                                                                                    <select
                                                                                        class="form-control text-center"
                                                                                        wire:model="datos_pack.{{ $itemPack->presupuesto_id }}.{{ $itemPack->pack_id }}.id_monitores.{{$servicioIndex}}.{{ $i }}"
                                                                                        name="servicio_seleccionado"
                                                                                        wire:change.debounce.500ms="cambioMonitorPack({{ $itemPack->presupuesto_id }}, {{ $itemPack->pack_id }})">
                                                                                        <option value="0">
                                                                                            Selecciona un
                                                                                            monitor.</option>
                                                                                        @foreach ($monitores as $keys => $monitor)
                                                                                            <option
                                                                                                class="dropdown-item"
                                                                                                value="{{ $monitor->id }}">
                                                                                                {{ $monitor->nombre }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </Select>
                                                                                </div>
                                                                                <div class="col-md-4 mt-1">
                                                                                    <input type="number"
                                                                                        wire:model="datos_pack.{{ $itemPack->presupuesto_id }}.{{ $itemPack->pack_id }}.sueldos_monitores.{{$servicioIndex}}.{{ $i }}"
                                                                                        wire:change.debounce.500ms="cambioMonitorPack({{ $itemPack->presupuesto_id }}, {{ $itemPack->pack_id }})"
                                                                                        class="form-control text-center"
                                                                                        placeholder="Sueldo">
                                                                                </div>
                                                                                <div class="col-md-4 mt-1">
                                                                                    <input type="number"
                                                                                        wire:model="datos_pack.{{ $itemPack->presupuesto_id }}.{{ $itemPack->pack_id }}.pagos_pendientes.{{$servicioIndex}}.{{ $i }}"
                                                                                        wire:change.debounce.500ms="cambioMonitorPack({{ $itemPack->presupuesto_id }}, {{ $itemPack->pack_id }})"
                                                                                        class="form-control text-center"
                                                                                        placeholder="Pendiente">
                                                                                </div>
                                                                            @endfor
                                                                        @endforeach
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h6 class="text-center">No hay eventos para este día.</h6>
                                @endif
                            </div>
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
