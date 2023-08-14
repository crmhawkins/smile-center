<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR PRESUPUESTO</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Presupuestos</a></li>
                    <li class="breadcrumb-item active">Crear Presupuesto</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">

        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>Presupuesto Servicios</h5>
                    <div class="form-row mb-4">
                        <div class="form-group col-md-3">
                            <label for="nPresupuesto">Presupuesto Nº</label>
                            <input type="text" wire:model.defer="nPresupuesto" class="form-control"
                                name="nPresupuesto" id="nPresupuesto" placeholder="X" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fechaEmision">Fecha presupuesto</label>
                            <input type="text" wire:model.defer="fechaEmision" class="form-control"
                                name="fechaEmision" id="fechaEmision" placeholder="X">
                        </div>
                    </div>

                    <div class="stepwizard">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button"
                                    class="btn btn-circle {{ $currentStep != 1 ? 'btn-default' : 'btn-primary' }}">1</a>
                                <p>Cliente</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-2" type="button"
                                    class="btn btn-circle {{ $currentStep != 2 ? 'btn-default' : 'btn-primary' }}">2</a>
                                <p>Evento</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-3" type="button"
                                    class="btn btn-circle {{ $currentStep != 3 ? 'btn-default' : 'btn-primary' }}"
                                    disabled="disabled">3</a>
                                <p>Más Info</p>
                            </div>
                        </div>
                    </div>
                    <form action="">
                        <div class="row setup-content {{ $currentStep != 1 ? 'displayNone' : '' }}" id="step-1">
                            {{-- <h5>Datos del solicitante</h5> --}}
                            <div class="form-row mt-3">
                                <h6>Seleccione el Cliente</h6>
                                <div class="form-group col-md-12">
                                    <div class="input-group mb-1">
                                        <br>
                                        <span class="col-md-2">Selecciona DNI/NIF de un cliente existente</span>
                                        <div class="col-md-8">
                                            <select class="form-control select js-example-basic-single"
                                                name="id_cliente" id="id_cliente" wire:model="id_cliente">
                                                <option value="0">NIF/DNI</option>
                                                @foreach ($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}">
                                                        {{ $cliente->nif }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ route('clientes.create') }}" class="btn btn-success w-100"
                                                target="_blank"> &nbsp;Cliente nuevo</a>
                                            {{-- <button type="button" class="btn btn-success waves-effect waves-light w-100" data-toggle="modal" data-target="#myModal">Standard Modal</button> --}}

                                            <div id="myModal" class="modal fade w-100 h-100" tabindex="-1"
                                                role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog w-100 my-0 "
                                                    style="height: 100vh !important;max-width: 100% !important">
                                                    <div class="modal-content" style="height: 100vh">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <livewire:clientes.create-component
                                                                :wire:key="$currentStep" />
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-secondary waves-effect"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button"
                                                                class="btn btn-primary waves-effect waves-light">Save
                                                                changes</button>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                @if ($id_cliente != 0 || $id_cliente != null)
                                    <div class="form-row">
                                        <!-- Tratamiento -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input"
                                                class="col-sm-12 col-form-label">Tratamiento</label>
                                            <div class="col-sm-10">
                                                <select class="input-group-text" name="trato" required disabled>
                                                    <option class="dropdown-item" value="" disabled>Trato
                                                    </option>
                                                    <option class="dropdown-item" value="M">M</option>
                                                    <option class="dropdown-item" value="Melle">Melle</option>
                                                    <option class="dropdown-item" value="Mme">Mme</option>
                                                </select>
                                                @error('trato')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Nombre -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>Nombre</label>
                                            <div class="col-sm-10">
                                                {{-- <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"> --}}
                                                <input type="text" value="{{ $clienteSeleccionado->nombre }}"
                                                    class="form-control" name="nombre" aria-label="Nombre"
                                                    placeholder="Nombre" disabled>
                                                @error('nombre')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Apellido -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input"
                                                class="col-sm-12 col-form-label">Apellido</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $clienteSeleccionado->apellido }}"
                                                    class="form-control" name="apellido" placeholder="Apellido"
                                                    disabled>
                                                @error('apellido')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <!-- NIF/DNI -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>NIF/DNI</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $clienteSeleccionado->nif }}"
                                                    class="form-control" name="nif" placeholder="Nif" disabled>
                                                @error('nif')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Tipo de Calle -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>Tipo de Calle</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $clienteSeleccionado->tipoCalle }}"
                                                    class="form-control" name="tipoCalle"
                                                    placeholder="Avenida/Plaza/Calle..." disabled>
                                                @error('tipoCalle')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Via -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>Via</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $clienteSeleccionado->calle }}"
                                                    class="form-control" name="calle" placeholder="Calle" disabled>
                                                @error('calle')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Nº -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>Nº</label>
                                            <div class="col-sm-10">
                                                <input type="number" value="{{ $clienteSeleccionado->numero }}"
                                                    class="form-control" name="numero" placeholder="1" disabled>
                                                @error('numero')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Dir Adi 1 -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>Dir Adi 1</label>
                                            <div class="col-sm-10">
                                                <input type="text"
                                                    value="{{ $clienteSeleccionado->direccionAdicional1 }}"
                                                    class="form-control" name="direccionAdicional1"
                                                    placeholder="Bloque/Letra..." disabled>
                                            </div>
                                        </div>

                                        <!-- Dir Adi 2 -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>Dir Adi 2</label>
                                            <div class="col-sm-10">
                                                <input type="text"
                                                    value="{{ $clienteSeleccionado->direccionAdicional2 }}"
                                                    class="form-control" name="direccionAdicional2"
                                                    placeholder="Bloque/Letra..." disabled>
                                            </div>
                                        </div>

                                        <!-- Dir Adi 3 -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>Dir Adi 3</label>
                                            <div class="col-sm-10">
                                                <input type="text"
                                                    value="{{ $clienteSeleccionado->direccionAdicional3 }}"
                                                    class="form-control" name="direccionAdicional3"
                                                    placeholder="Bloque/Letra..." disabled>
                                            </div>
                                        </div>

                                        <!-- CP -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>CP</label>
                                            <div class="col-sm-10">
                                                <input type="number"
                                                    value="{{ $clienteSeleccionado->codigoPostal }}"
                                                    class="form-control" name="codigoPostal" placeholder="XXXXX"
                                                    disabled>
                                                @error('codigoPostal')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Ciudad -->
                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"
                                                disabled>Ciudad</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $clienteSeleccionado->ciudad }}"
                                                    class="form-control" name="ciudad" placeholder="Ciudad"
                                                    disabled>
                                                @error('ciudad')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Confirmacion Postal -->
                                        <div class="form-group col-md-4">
                                            <label for="confPostal" class="col-sm-12 col-form-label"
                                                disabled>Confirmacion Postal</label>
                                            <div class="col-sm-10">
                                                <input class="form-check-input mt-0"
                                                    @if ($clienteSeleccionado->confPostal == 1) checked @endif type="checkbox"
                                                    value="" name="confPostal"
                                                    aria-label="Checkbox for following text input" disabled>
                                                {{-- <span class="input-group-text">Confirmacion Postal</span> --}}
                                            </div>
                                        </div>

                                        <!-- Telefono -->
                                        <div class="form-group col-md-4">
                                            <label for="tlf1" class="col-sm-12 col-form-label"
                                                disabled>Telefono</label>
                                            <div class="col-sm-10">
                                                <input type="number" value="{{ $clienteSeleccionado->tlf1 }}"
                                                    class="form-control" name="tlf1" placeholder="XXXXXXXXX"
                                                    disabled>
                                                @error('tlf1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Telefono Secundario -->
                                        <div class="form-group col-md-4">
                                            <label for="tlf2" class="col-sm-12 col-form-label" disabled>Telefono
                                                Secundario</label>
                                            <div class="col-sm-10">
                                                <input type="number" value="{{ $clienteSeleccionado->tlf2 }}"
                                                    class="form-control" name="tlf2" placeholder="Opcional"
                                                    disabled>
                                            </div>
                                        </div>

                                        <!-- Telefono Adicional -->
                                        <div class="form-group col-md-4">
                                            <label for="tlf3" class="col-sm-12 col-form-label" disabled>Telefono
                                                Adicional</label>
                                            <div class="col-sm-10">
                                                <input type="number" value="{{ $clienteSeleccionado->tlf3 }}"
                                                    class="form-control" name="tlf3" placeholder="Opcional"
                                                    disabled>
                                            </div>
                                        </div>

                                        <!-- Confirmacion SMS -->
                                        <div class="form-group col-md-4">
                                            <label for="confSms" class="col-sm-12 col-form-label"
                                                disabled>Confirmacion SMS</label>
                                            <div class="col-sm-10">
                                                <input class="form-check-input mt-0"
                                                    @if ($clienteSeleccionado->confSms == 1) checked @endif type="checkbox"
                                                    value="" aria-label="Checkbox for following text input"
                                                    disabled>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group col-md-4">
                                            <label for="email1" class="col-sm-12 col-form-label"
                                                disabled>Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $clienteSeleccionado->email1 }}"
                                                    class="form-control" name="email1" placeholder="Email@email.com"
                                                    disabled>
                                                @error('email1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email Secundario -->
                                        <div class="form-group col-md-4">
                                            <label for="email1" class="col-sm-12 col-form-label" disabled>Email
                                                Secundario</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $clienteSeleccionado->email2 }}"
                                                    class="form-control" name="email2" placeholder="email@email.com"
                                                    disabled>
                                            </div>
                                        </div>

                                        <!-- Email Adicional -->
                                        <div class="form-group col-md-4">
                                            <label for="email1" class="col-sm-12 col-form-label" disabled>Email
                                                Adicional</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $clienteSeleccionado->email3 }}"
                                                    class="form-control" name="email3" placeholder="Email@email.com"
                                                    disabled>
                                            </div>
                                        </div>

                                        <!-- Confirmacion Email -->
                                        <div class="form-group col-md-4">
                                            <label for="confEmail" class="col-sm-12 col-form-label"
                                                disabled>Confirmacion Email</label>
                                            <div class="col-sm-10">
                                                <input class="form-check-input mt-0"
                                                    @if ($clienteSeleccionado->confEmail == 1) checked @endif type="checkbox"
                                                    value="" aria-label="Checkbox for following text input"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{var_dump($clienteSeleccionado)}} --}}
                                @endif
                            </div>
                            <button type="button" wire:click="primerPaso()"
                                class="btn btn-secondary mt-4">Siguiente</button>
                        </div>
                        <div class="row setup-content {{ $currentStep != 2 ? 'displayNone' : '' }}" id="step-2">
                            {{-- <h3>Paso 2</h3> --}}
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="diaEvento" class="col-sm-12 col-form-label">Dia del evento</label>
                                    <div class="col-sm-10">
                                        <input type="date" wire:model="diaEvento" class="form-control"
                                            name="diaEvento" id="diaEvento" placeholder="X">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="diaFinal" class="col-sm-12 col-form-label">Dia final del
                                        evento</label>
                                    <div class="col-sm-10">
                                        <input type="date" wire:model="diaFinal" class="form-control"
                                            name="diaFinal" id="diaFinal" placeholder="X">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="eventoNombre" class="col-sm-12 col-form-label">Evento</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.lazy="eventoNombre" class="form-control"
                                            name="eventoNombre" id="eventoNombre" placeholder="Evento">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="eventoProtagonista"
                                        class="col-sm-12 col-form-label">Protagonistas</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.lazy="eventoProtagonista"
                                            class="form-control" name="eventoProtagonista" id="eventoProtagonista"
                                            placeholder="Protagonistas">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="eventoNiños" class="col-sm-12 col-form-label">Nº Niños</label>
                                    <div class="col-sm-10">
                                        <input type="number" wire:model.lazy="eventoNiños" class="form-control"
                                            name="eventoNiños" id="eventoNiños" placeholder="0">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="eventoAdultos" class="col-sm-12 col-form-label">Nº Adultos</label>
                                    <div class="col-sm-10">
                                        <input type="number" wire:model.lazy="eventoAdultos" class="form-control"
                                            name="eventoAdultos" id="eventoAdultos" placeholder="0">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="eventoContacto" class="col-sm-12 col-form-label">Contacto</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.lazy="eventoContacto" class="form-control"
                                            name="eventoContacto" id="eventoContacto" placeholder="Contacto">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="eventoParentesco" class="col-sm-12 col-form-label">Parentesco</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.lazy="eventoParentesco" class="form-control"
                                            name="eventoParentesco" id="eventoParentesco" placeholder="Parentesco">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="eventoTelefono" class="col-sm-12 col-form-label">Telefono</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.lazy="eventoTelefono" class="form-control"
                                            name="eventoTelefono" id="eventoTelefono" placeholder="Telefono">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="eventoLugar" class="col-sm-12 col-form-label">Lugar</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.lazy="eventoLugar" class="form-control"
                                            name="eventoLugar" id="eventoLugar" placeholder="Lugar">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="eventoLocalidad" class="col-sm-12 col-form-label">Localidad</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.lazy="eventoLocalidad" class="form-control"
                                            name="eventoLocalidad" id="eventoLocalidad" placeholder="Localidad">
                                    </div>
                                </div>
                                <!-- Confirmacion Email -->
                                <div class="form-group col-md-4">
                                    <label for="eventoMontaje" class="col-sm-12 col-form-label" disabled>Posibilidad
                                        de Montaje</label>
                                    <div class="col-sm-10">
                                        <input class="form-check-input mt-0" wire:model="eventoMontaje"
                                            type="checkbox" value="" id="eventoMontaje"
                                            aria-label="Checkbox for following text input" disabled>
                                    </div>
                                </div>
                                {{-- <div class="form-group col-md-12">
                                    <button type="button" id="guardar-evento" class="btn btn-info guardar w-100 mt-3"
                                        wire:click="submitEvento">Guardar Evento</button>
                                    <button type="button" class="btn btn-danger guardar evento w-100 mt-3"
                                        wire:click="uncheckEvent">Cancelar Edición</button>
                                </div> --}}

                            </div>
                            <button type="button" wire:click="segundoPaso()"
                                class="btn btn-secondary">Siguiente</button>

                        </div>

                        {{-- <div class="row setup-content {{ $currentStep != 4 ? 'displayNone' : '' }}" id="step-4">
                            <select class="input-group-text" name="diasSelect" id="diasSelect"
                                wire:model.defer="dia">
                                <option class="dropdown-item" value="">Servicio</option>
                                @foreach ($dias as $i => $day)
                                    <option class="dropdown-item" wire:click="setUpServiceForm({{ $i }})"
                                        value="{{ $day }}">{{ "Dia $i $day" }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="input-group-text" name="packSelect" id="packSelect"
                                wire:model.defer="pack">
                                <option class="dropdown-item" value="">Paquete</option>
                                @foreach ($packs as $i => $pack)
                                    <option class="dropdown-item" value="{{ $pack->id }}">
                                        {{ "Paquete $pack->nombre" }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary"
                                wire:click="addServiceFieldFromPack">+Paquete</button>
                            @if (count($serviciosListDia))
                                @foreach ($serviciosListDia[$dia] as $key => $servicioEvento)
                                    <br>
                                    <style>
                                        .servicio {
                                            padding: 5px;
                                            background-color: rgb(184, 245, 184)
                                        }

                                        .programa {
                                            background-color: rgb(204, 233, 243);
                                            padding: 5px;
                                        }
                                    </style>

                                    <div class="servicio">

                                        <div class="input-group mb-3 servicio">

                                            <select class="input-group-text"
                                                name="serviciosListDia.{{ $dia }}.{{ $key }}.id_servicio"
                                                id="serviciosListDia{{ $dia }}.{{ $key }}.id_servicio"
                                                wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.id_servicio">
                                                <option class="dropdown-item" value="">Servicio</option>
                                                @foreach ($servicios as $servicio)
                                                    <option class="dropdown-item"
                                                        wire:click="setDefaultServicios({{ $key }}, {{ $servicio->id }}, {{ $dia }})"
                                                        value="{{ $servicio->id }}">{{ $servicio->nombre }}
                                                    </option>
                                                @endforeach
                                                <option class="dropdown-item" value=""
                                                    wire:click.prevetn="crearServicio">
                                                    Crear
                                                    Servicio</option>
                                            </select>


                                            <span class="input-group-text">Importe Base:
                                                {{ $servicioEvento['importeBase'] }}€</span>

                                            <span class="input-group-text">Descuento </span>
                                            <input type="number"
                                                wire:change="applyServiceDiscount({{ $key }})"
                                                wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.descuento"
                                                class="form-control"
                                                name="serviciosListDia.{{ $dia }}.{{ $key }}.descuento"
                                                id="serviciosListDia.{{ $dia }}.{{ $key }}.descuento"
                                                placeholder="0">
                                            <span class="input-group-text">% </span>

                                            <span class="input-group-text">Total:
                                                {{ $servicioEvento['importe'] }}€</span>

                                            <span class="input-group-text">Comienzo Montaje </span>
                                            <input type="time"
                                                wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.comienzoMontaje"
                                                class="form-control"
                                                name="serviciosListDia.{{ $dia }}.{{ $key }}.comienzoMontaje"
                                                id="serviciosListDia.{{ $dia }}.{{ $key }}.comienzoMontaje"
                                                {{-- wire:change="refreshEndTime({{ $key }})"  --}} {{-- placeholder="00:00">

                                            <span class="input-group-text">Tiempo Montaje </span>
                                            <input type="number" required
                                                wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.tiempoMontaje"
                                                wire:change="refreshEndTime({{ $key }})"
                                                class="form-control"
                                                name="serviciosListDia.{{ $dia }}.{{ $key }}.tiempoMontaje"
                                                id="serviciosListDia.{{ $dia }}.{{ $key }}.tiempoMontaje"
                                                placeholder="0">
                                            <span class="input-group-text">Minutos </span>

                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Hora Inicio </span>
                                            <input type="time"
                                                wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.horaInicio"
                                                class="form-control"
                                                name="serviciosListDia.{{ $dia }}.{{ $key }}.horaInicio"
                                                id="serviciosListDia.{{ $dia }}.{{ $key }}.horaInicio"
                                                wire:change="refreshEndTime({{ $key }})"
                                                placeholder="00:00">

                                            <span class="input-group-text">Duración </span>
                                            <input type="number" required
                                                wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.tiempo"
                                                wire:change="refreshEndTime({{ $key }})"
                                                class="form-control"
                                                name="serviciosListDia.{{ $dia }}.{{ $key }}.tiempo"
                                                id="serviciosListDia.{{ $dia }}.{{ $key }}.tiempo"
                                                placeholder="0">
                                            <span class="input-group-text">Horas </span>

                                            <span class="input-group-text">
                                                Hora final:
                                                {{ substr($servicioEvento['horaFin'], 0, 5) }}
                                            </span>

                                            <span class="input-group-text">Tiempo Desmontaje </span>
                                            <input type="number" required
                                                wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.tiempoDesmontaje"
                                                {{-- wire:change="refreshEndTime({{ $key }})"   --}} {{-- class="form-control"
                                                name="serviciosListDia.{{ $dia }}.{{ $key }}.tiempoDesmontaje"
                                                id="serviciosListDia.{{ $dia }}.{{ $key }}.tiempoDesmontaje"
                                                placeholder="0">
                                            <span class="input-group-text">Minutos </span>

                                            <span class="input-group-text">Monitores </span>
                                            <input type="number"
                                                wire:change="refreshNumMonitores({{ $key }})"
                                                wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.numMonitores"
                                                class="form-control"
                                                name="serviciosListDia.{{ $dia }}.{{ $key }}.numMonitores"
                                                id="serviciosListDia.{{ $dia }}.{{ $key }}.numMonitores"
                                                placeholder="1">




                                        </div>
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-primary"
                                                @if ($serviciosListDia[$dia][$key]['id_servicio'] == 0) disabled @endif
                                                wire:click="addServiceField({{ $dia }})">+Servicio</button>


                                            <button type="button" class="btn btn-danger"
                                                @if (count($serviciosListDia[$dia]) <= 1) disabled @endif
                                                wire:click="removeServicio({{ $key }})">Eliminar</button>
                                        </div>
                                    </div>
                                    @if ($serviciosListDia[$dia][$key]['numMonitores'] > 0)
                                        <div class="programa" style="width: 100%">
                                            <div class="container-md text-center">
                                                <h4>Monitores:</h4>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach ($serviciosListDia[$dia][$key]['programas'] as $i => $programaServicio)
                                        <div class="programa">


                                            <div class="input-group mb-3">
                                                <select class="input-group-text" required
                                                    name="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.'id_monitor'"
                                                    id="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.'id_monitor'"
                                                    wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.id_monitor">
                                                    <option class="dropdown-item" value="">Monitor
                                                        {{ $i + 1 }}</option>
                                                    @foreach ($monitores as $monitor)
                                                        <option class="dropdown-item" value="{{ $monitor->id }}">
                                                            {{ $this->nombreMonitor($monitor->id) }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <span class="input-group-text">Horas</span>
                                                <input type="number" required
                                                    wire:change="checkTime({{ $key }}, {{ $i }})"
                                                    wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.horas"
                                                    class="form-control"
                                                    name="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.horas"
                                                    id="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.horas"
                                                    placeholder="1">

                                                <span class="input-group-text">Sueldo</span>


                                                <input type="number" required
                                                    wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.precioMonitor"
                                                    wire:change="sumarCostoMonitor({{ $servicioEvento['id_servicio'] }}, {{ $key }}, {{ $i }})"
                                                    class="form-control"
                                                    name="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.precioMonitor"
                                                    id="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.precioMonitor">
                                                <span class="input-group-text">€</span>


                                                <span class="input-group-text">Desplazamiento</span>


                                                <input type="number" required
                                                    wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.costoDesplazamiento"
                                                    class="form-control"
                                                    name="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.costoDesplazamiento"
                                                    id="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.costoDesplazamiento"
                                                    wire:change="sumarCostoMonitor({{ $servicioEvento['id_servicio'] }}, {{ $key }}, {{ $i }})"
                                                    placeholder="1">
                                                <span class="input-group-text">€</span>

                                                <span class="input-group-text">Inicio</span>
                                                <input type="time" required
                                                    wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.comienzoEvento"
                                                    class="form-control"
                                                    name="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.comienzoEvento"
                                                    id="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.comienzoEvento"
                                                    placeholder="1">
                                                <span class="input-group-text">Comienzo Montaje</span>
                                                <input type="time" required
                                                    wire:model.defer="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.comienzoMontaje"
                                                    class="form-control"
                                                    name="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.comienzoMontaje"
                                                    id="serviciosListDia.{{ $dia }}.{{ $key }}.programas.{{ $i }}.comienzoMontaje"
                                                    placeholder="1">


                                            </div>

                                        </div>
                                    @endforeach
                                @endforeach
                            @endif


                            @if (count($serviciosListDia) > 0)
                                <div class="container text-center">
                                    <br>
                                    <br>
                                    @if ($addObservaciones)
                                        <h2>Observaciones</h2>
                                        <textarea class="form-control" wire:model="observaciones" id="observaciones" rows="5"></textarea>
                                    @else
                                        <button type="button" wire:click="allowObs"
                                            class="btn btn-outline-info">Añadir
                                            observaciones</button>
                                    @endif
                                    <br>
                                    <br>
                                </div>
                            @endif

                            @if (count($serviciosListDia) > 0)

                                <div class="container-md ">
                                    <div class="container-md text-center">
                                        <h2>RESERVA SERVICIOS CONTRATADOS</h2>
                                    </div>
                                    <br>
                                    <div class="input-group ms">

                                        <button class="btn btn-outline-secondary" type="button"
                                            wire:click="allowDisabDisc"">
                                            @if ($addDiscount)
                                                Eliminar descuento
                                            @else
                                                Añadir descuento
                                            @endif
                                        </button>
                                        @if ($addDiscount)
                                            <span class="input-group-text">Descuento</span>
                                            <input type="number" wire:change="getTotalPrice"
                                                wire:model.defer="descuento" class="form-control" name="descuento"
                                                id="descuento" placeholder="0">
                                            <span class="input-group-text">%</span>

                                            <span class="input-group-text">Total Servicios Contratados:</span>
                                            <span
                                                class="input-group-text">{{ number_format($precioFinal, 2, ',', '.') }}€</span>
                                            <span class="input-group-text">Entrega:</span>
                                            <input type="number" wire:change="getTotalPrice"
                                                wire:model.defer="adelanto" class="form-control" name="adelanto"
                                                id="adelanto" placeholder="0">
                                            <span class="input-group-text">%</span>
                                            <span
                                                class="input-group-text">{{ number_format($entregaDiscount, 2, ',', '.') }}€</span>
                                        @else
                                            <span class="input-group-text">Total Servicios Contratados:</span>
                                            <span
                                                class="input-group-text">{{ number_format($precioBase, 2, ',', '.') }}€</span>
                                            <span class="input-group-text">Entrega:</span>
                                            <input type="number" wire:change="getTotalPrice"
                                                wire:model.defer="adelanto" class="form-control" name="adelanto"
                                                id="adelanto" placeholder="0">
                                            <span class="input-group-text">%</span>
                                            <span
                                                class="input-group-text">{{ number_format($entrega, 2, ',', '.') }}€</span>
                                        @endif
                                    </div>

                            @endif
                        </div> --}}

                        <div class="row setup-content {{ $currentStep != 3 ? 'displayNone' : '' }}" id="step-3">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <h5><label for="tipo_seleccionado" class="col-sm-12 col-form-label">¿Qué se va a
                                            añadir?</label></h5>
                                </div>
                                <div class="col-md-6" style="margin-top: -50px !important;">
                                    <div class="col-md-1">
                                        &nbsp;
                                    </div>
                                    <h6>
                                        <div class="col-md-11">
                                            <input wire:model="tipo_seleccionado" name="tipo_seleccionado"
                                                type="radio" value="pack" /> Packs de servicios
                                            &nbsp;
                                            &nbsp;
                                            &nbsp;

                                            <input wire:model="tipo_seleccionado" name="tipo_seleccionado"
                                                type="radio" value="individual" /> Servicio individual
                                        </div>
                                    </h6>
                                </div>
                            </div>
                            <div class="form-row">
                                @if ($tipo_seleccionado == 'individual')
                                    <div class="form-group col-md-6">
                                        <label for="diaEvento" class="col-sm-12 col-form-label">Servicios</label>
                                        <div class="col-md-12">
                                            <Select wire:model="servicio_seleccionado" class="form-control"
                                                name="servicio_seleccionado" id="servicios">
                                                <option value="0">Selecciona un servicio.</option>
                                                @foreach ($servicios as $keys => $servicio)
                                                    <option class="dropdown-item" value="{{ $servicio->id }}">
                                                        {{ $servicio->nombre }}
                                                    </option>
                                                @endforeach
                                            </Select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="precioServicio" class="col-sm-12 col-form-label">Monitores</label>
                                        <div class="col-md-12">
                                            <input type="number" wire:model.lazy="numero_monitores"
                                                min="{{ $servicio->minMonitor }}"
                                                wire:change="cambioPrecioServicio()" class="form-control"
                                                name="numero_monitores" id="numero_monitores"
                                                placeholder="Número de monitores">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="precioServicio" class="col-sm-12 col-form-label">Precio</label>
                                        <div class="col-md-12">
                                            <input type="text" wire:model.lazy="precioFinalServicio"
                                                class="form-control" name="precioFinalServicio"
                                                id="precioFinalServicio" placeholder="Precio final">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 text-center">
                                        <label for="precioServicio" class="col-sm-12 col-form-label">&nbsp;</label>
                                        <button class="btn btn-primary w-100"
                                            wire:click.prevent="addServicio">Añadir</button>
                                    </div>
                                @elseif($tipo_seleccionado == 'pack')
                                    <div class="form-group col-md-10">
                                        <label for="diaEvento" class="col-sm-12 col-form-label">Packs de
                                            servicios</label>
                                        <div class="col-md-12">
                                            <Select wire:model="pack_seleccionado" class="form-control"
                                                name="pack_seleccionado" id="pack_seleccionado">
                                                <option value="0">Selecciona un paquete de servicios.</option>
                                                @foreach ($packs as $keys => $pack)
                                                    <option class="dropdown-item" value="{{ $pack->id }}"
                                                        selected>
                                                        {{ $pack->nombre }}
                                                    </option>
                                                @endforeach
                                            </Select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 text-center">
                                        <label for="precioServicio" class="col-sm-12 col-form-label">&nbsp;</label>

                                        <button class="btn btn-primary w-100"
                                            wire:click.prevent="addPack()">Añadir</button>
                                    </div>
                                    @if ($pack_seleccionado != null)
                                        @foreach ($packs->where('id', 1)->first()->servicios()->get() as $keyPack => $servicio)
                                            <div class="form-group col-md-4">
                                                <label for="precioServicio"
                                                    class="col-sm-12 col-form-label">Servicio</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="{{ $servicio->nombre }}"
                                                        class="form-control" name="precioServicio"
                                                        placeholder="Evento">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="precioServicio"
                                                    class="col-sm-12 col-form-label">Monitores</label>
                                                <div class="col-md-12">
                                                    <input type="number"
                                                        wire:model="preciosMonitores.{{ $keyPack }}"
                                                        min="{{ $servicio->minMonitor }}"
                                                        wire:change='cambioPrecioPack' class="form-control"
                                                        name="precioServicio" placeholder="Número de monitores"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="precioServicio" class="col-sm-12 col-form-label">Precio
                                                    base</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="precioServicio"
                                                        wire:change='cambioPrecioPack'
                                                        @if (isset($preciosMonitores[$keyPack])) value="{{ $servicio->precioBase + $preciosMonitores[$keyPack] * $servicio->precioMonitor }} "
                                                       @else
                                                       value="{{ $servicio->precioBase }}" @endif
                                                        placeholder="Dias" disabled>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="form-group col-md-12">
                                            <label for="precioServicio" class="col-sm-12 col-form-label">Precio final
                                                del pack</label>
                                            <div class="col-md-12">
                                                <input type="number" class="form-control"
                                                    wire:model="precioFinalPack" placeholder="Evento">
                                            </div>
                                        </div>
                                    @endif
                                @else
                                @endif
                                <div class="form-group col-md-12">
                                    <h4>Listado de packs y servicios seleccionados</h4>
                                    <h5> Packs seleccionados </h5>
                                    <ul>
                                        @foreach ($listaPacks as $packIndex => $pack)
                                            <li>
                                                <h6>{{ $packs->where('id', $pack['id'])->first()->nombre }} -
                                                    {{ $pack['precioFinal'] }} € -
                                                    {{ array_sum($pack['numero_monitores']) }} monitores <button type="button" class="btn btn-sm btn-danger" wire:click.prevent="deletePack('{{$packIndex}}')">X</button></h6>

                                                <ul>
                                                    @foreach ($packs->where('id', $pack['id'])->first()->servicios()->get() as $keyPack => $servicioPack)
                                                        <li> {{ $servicioPack->nombre }} -
                                                            {{ $pack['numero_monitores'][$keyPack] }} monitores
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <h5> Servicios individuales seleccionados </h5>
                                    <ul>
                                        @foreach ($listaServicios as $servicioIndex => $itemServicio)
                                            <li>
                                                <h6>{{ $servicios->where('id', $itemServicio['id'])->first()->nombre }}
                                                    -
                                                    {{ $itemServicio['precioFinal'] }} € -
                                                    {{ $itemServicio['numero_monitores'] }} monitores <button type="button" class="btn btn-sm btn-danger" wire:click.prevent="deleteServicio('{{$servicioIndex}}')">X</button></h6>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="precioServicio" class="col-sm-12 col-form-label">Subtotal</label>
                                    <div class="col-md-12">
                                        <input type="text" wire:model.lazy="precioFinal" class="form-control"
                                            name="precioFinal" id="precioFinal" disabled placeholder="Precio final">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="precioServicio" class="col-sm-12 col-form-label">Descuento</label>
                                    <div class="col-md-12">
                                        <input type="number" wire:model.lazy="descuento" class="form-control"
                                            name="descuento" id="descuento" max="{{ $this->precioFinal }}"
                                            placeholder="Precio final">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="precioServicio" class="col-sm-12 col-form-label">Adelanto</label>
                                    <div class="col-md-12">
                                        <input type="number" wire:model.lazy="adelanto" class="form-control"
                                            name="adelanto" id="adelanto"
                                            max="{{ $this->precioFinal - $this->descuento }}"
                                            placeholder="Precio final">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="precioServicio" class="col-sm-12 col-form-label">&nbsp;</label>
                                    <h4>Total: {{ $this->precioFinal - $this->descuento }} € @if ($adelanto > 0 || $adelanto != null)
                                            ( {{ $this->adelanto }} € pagado por adelantado. )
                                        @endif
                                    </h4>
                                </div>
                                {{-- <div class="form-group col-md-12">
                                    <button type="button" id="guardar-evento" class="btn btn-info guardar w-100 mt-3"
                                        wire:click="submitEvento">Guardar Evento</button>
                                    <button type="button" class="btn btn-danger guardar evento w-100 mt-3"
                                        wire:click="uncheckEvent">Cancelar Edición</button>
                                </div> --}}
                            </div>
                        </div>
                    </form>
                    {{-- <div class="mb-3 row d-flex align-items-center">
                        <button type="submit" class="btn btn-primary w-100">Guardar Presupuesto</button>
                    </div>  --}}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>Acciones</h5>
                    <div class="row">
                        <div class="col-12">
                            <button class="w-100 btn btn-success mb-2" id="alertaGuardar">Guardar
                                Presupuesto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;
        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }

        .displayNone {
            display: none;
        }
    </style>

</div>

@section('scripts')
    {{-- <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script> --}}
    <script>
        // In your Javascript (external .js resource or <script> tag)

        $("#alertaGuardar").on("click", () => {
            Swal.fire({
                title: '¿Estás seguro?',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('submitEvento');
                }
            });
        });

        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'yy-mm-dd',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        // document.addEventListener('livewire:load', function() {


        // })
        document.addEventListener("livewire:load", () => {
            Livewire.hook('message.processed', (message, component) => {
                $('.js-example-basic-single').select2();
            });

            // $('#id_cliente').on('change', function (e) {
            // console.log('change')
            // console.log( e.target.value)
            // // var data = $('.js-example-basic-single').select2("val");
            // })
        });



        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            // $('.js-example-basic-single').on('change', function (e) {
            // console.log('change')
            // console.log( e.target.value)
            // var data = $('.js-example-basic-single').select2("val");

            // @this.set('foo', data);
            //     livewire.emit('selectedCompanyItem', e.target.value)
            // });
            // $('#tableServicios').DataTable({
            //     responsive: true,
            //     dom: 'Bfrtip',
            //     buttons: [
            //         'copy', 'csv', 'excel', 'pdf', 'print'
            //     ],
            //     buttons: [{
            //         extend: 'collection',
            //         text: 'Export',
            //         buttons: [{
            //                 extend: 'pdf',
            //                 className: 'btn-export'
            //             },
            //             {
            //                 extend: 'excel',
            //                 className: 'btn-export'
            //             }
            //         ],
            //         className: 'btn btn-info text-white'
            //     }],
            //     "language": {
            //         "lengthMenu": "Mostrando _MENU_ registros por página",
            //         "zeroRecords": "Nothing found - sorry",
            //         "info": "Mostrando página _PAGE_ of _PAGES_",
            //         "infoEmpty": "No hay registros disponibles",
            //         "infoFiltered": "(filtrado de _MAX_ total registros)",
            //         "search": "Buscar:",
            //         "paginate": {
            //             "first": "Primero",
            //             "last": "Ultimo",
            //             "next": "Siguiente",
            //             "previous": "Anterior"
            //         },
            //         "zeroRecords": "No se encontraron registros coincidentes",
            //     }

        });



        // $("#fechaEmision").datepicker();


        // $("#fechaEmision").on('change', function(e) {
        //     @this.set('fechaEmision', $('#fechaEmision').val());
        // });



        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.className = "fas fa-eye-slash";
            } else {
                passwordInput.type = "password";
                eyeIcon.className = "fas fa-eye";
            }
        }

        //observer para aplicar el datepicker de evento
        // const observer = new MutationObserver((mutations, observer) => {
        //     console.log(mutations, observer);
        // });
        // observer.observe(document, {
        //     subtree: true,
        //     attributes: true
        // });



        document.addEventListener('DOMSubtreeModified', (e) => {
            $("#diaEvento").datepicker();

            // $("#diaEvento").on('focus', function(e) {
            //     document.getElementById("guardar-evento").style.visibility = "hidden";
            // })
            // $("#diaEvento").on('focusout', function(e) {
            //     if ($('#diaEvento').val() != "") {
            //         document.getElementById("guardar-evento").style.visibility = "visible";
            //     }

            // })
            // $("#diaFinal").on('focus', function(e) {
            //     document.getElementById("guardar-evento").style.visibility = "hidden";
            // })
            // $("#diaFinal").on('focusout', function(e) {
            //     if ($('#diaFinal').val() != "") {
            //         document.getElementById("guardar-evento").style.visibility = "visible";
            //     }

            // })

            $("#diaFinal").datepicker();

            $("#diaFinal").on('change', function(e) {
                @this.set('diaFinal', $('#diaFinal').val());

            });

            $("#diaEvento").on('change', function(e) {
                @this.set('diaEvento', $('#diaEvento').val());
                @this.set('diaFinal', $('#diaEvento').val());

            });

            $('#id_cliente').on('change', function(e) {
                console.log('change')
                console.log(e.target.value)
                var data = $('#id_cliente').select2("val");
                @this.set('id_cliente', data);
                Livewire.emit('selectCliente')

                // livewire.emit('selectedCompanyItem', data)
            })
        })

        function OpenSecondPage() {
            var id = @this.id_cliente
            window.open(`/admin/clientes-edit/` + id, '_blank'); // default page
        };
    </script>
@endsection
