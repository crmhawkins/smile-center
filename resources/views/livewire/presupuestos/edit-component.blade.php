<div class="container-fluid">
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.apple-mapkit.com/mk/5.x.x/mapkit.js" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR PRESUPUESTO</h4>
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
                    <div class="form-row mb-4 justify-content-center">
                        <div class="form-group col-md-12">
                            <h5
                                style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">Datos
                                básicos del presupuesto</h5>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fechaEmision">Fecha de emisión</label>
                            <input type="date" wire:model="fechaEmision" class="form-control"
                                name="fechaEmision" id="fechaEmision" placeholder="X">
                            @error('fechaEmision')
                                <span class="text-danger">{{ $message }}</span>
                                <style>
                                    .nombre { color: red;}
                                </style>
                            @enderror
                        </div>
                        <div class="form-group col-md-4" wire:ignore>
                            <label for="fechaVencimiento">Estado</label>
                            <select data-pharaonic="select2"
                                    data-component-id="{{ $this->id }}"
                                    class="form-control"
                                    wire:model="estado_id"
                                    data-placeholder="Estado"
                                    data-clear>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">
                                        {{ $estado->estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_id')
                            <span class="text-danger">{{ $message }}</span>
                            <style>
                                .nombre { color: red;}
                            </style>
                        @enderror
                        </div>
                        <div class="form-group col-md-4" wire:ignore>
                            <label for="paciente_id">Paciente</label>
                            <select data-pharaonic="select2"
                                data-component-id="{{ $this->id }}"
                                class="form-control"
                                wire:model="paciente_id"
                                data-placeholder="Paciente"
                                data-clear>
                                    <option value=""></option>
                                    @foreach ($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}">
                                            {{ $paciente->nombre }} {{ $paciente->apellido }}
                                        </option>
                                    @endforeach
                            </select>
                            @error('paciente_id')
                            <span class="text-danger">{{ $message }}</span>
                            <style>
                                .nombre { color: red;}
                            </style>
                        @enderror
                        </div>
                        <div class="form-group col-md-12" wire:ignore>
                            <label for="observacion">Observaciones</label>
                            <textarea type="text" wire:model.lazy="observacion" class="form-control" name="observacion"
                            id="observacion" aria-label="observacion" placeholder="Observaciones"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <h5 style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">
                               Datos del servicio a contratar</h5>
                        </div>
                        <div class="form-group col-md-10"wire:ignore>
                            <label for="diaEvento" class="col-sm-12 col-form-label">Servicios</label>
                            <div class="col-md-12">
                                <select data-pharaonic="select2"
                                    data-component-id="{{ $this->id }}"
                                    class="form-control"
                                    wire:model="servicio_seleccionado"
                                    data-placeholder="Seleccione el servicio"
                                    id="servicio_seleccionado"
                                    data-clear>
                                    <option value="0">Selecciona un servicio</option>
                                    @foreach ($servicios as $servicio)
                                        <option class="dropdown-item" value="{{$servicio->id}}">
                                            {{ $servicio->nombre }}
                                        </option>
                                    @endforeach
                                </Select>
                            </div>
                        </div>
                        <div class="form-group col-md-2 text-center">
                            <label for="precioServicio" class="col-sm-12 col-form-label">&nbsp;</label>
                            <button class="btn btn-primary w-100" wire:click.prevent="addServicio">Añadir</button>
                        </div>
                        <div class="form-group col-md-12">
                            <h5 class="ms-3" style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">Servicios contratados</h5>
                        </div>
                        <div class="form-group col-md-12">
                            @if (count($listaServicios) > 0)
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Servicio</th>
                                            <th>Descipción</th>
                                            <th>Precio</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    @foreach ($listaServicios as $index => $servicio)
                                        <tbody>
                                            <tr>
                                                <td>{{ $servicio['nombre']}}</td>
                                                <td>{{ $servicio['descripcion']}}</td>
                                                <td>{{ $servicio['precio']}} €</td>
                                                <td><button type="button" class="btn btn-sm btn-danger"wire:click.prevent="deleteServicio('{{ $index }}')">X</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>Opciones de guardado</h5>
                    <div class="row">
                        <div class="col-12">
                            <button class="w-100 btn btn-success mb-2" wire:click.prevent="alertaGuardar">Actualizar presupuesto</button>
                            <button class="w-100 btn btn-danger mb-2" wire:click.prevent="alertaEliminar">Borrar presupuesto</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>Acciones</h5>
                    <div class="row">
                        <div class="col-12">
                            <button class="w-100 btn btn-info mb-2" wire:click.prevent="crearCita">Generar Cita</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            // Inicializar select2
            $('#servicio_seleccionado').select2();

            // Actualizar select2 cuando se emita el evento
            Livewire.on('resetSelect2', () => {
                $('#servicio_seleccionado').val(null).trigger('change');
            });

            // Actualizar Livewire cuando se cambie select2
            $('#servicio_seleccionado').on('change', function (e) {
                @this.set('servicio_seleccionado', $(this).val());
            });
        });
        // $("#alertaGuardar").on("click", () => {
        //     Swal.fire({
        //         title: '¿Estás seguro?',
        //         icon: 'warning',
        //         showConfirmButton: true,
        //         showCancelButton: true
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             window.livewire.emit('update');
        //         }
        //     });
        // });
    </script>
@endsection
