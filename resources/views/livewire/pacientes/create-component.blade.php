<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR PACIENTE</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pacientes</a></li>
                    <li class="breadcrumb-item active">Crear paciente</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ csrf_token() }}">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h5 class="ms-3" style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">
                                Datos del Paciente</h5>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">Nombre</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.lazy="nombre" class="form-control" name="nombre"
                                            id="nombre" aria-label="Nombre" placeholder="Nombre">
                                        @error('nombre')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>
                                                .nombre {
                                                    color: red;
                                                }
                                            </style>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">Apellidos</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.lazy="apellido" class="form-control" name="apellido"
                                        id="apellido" placeholder="Apellidos">
                                        @error('apellido')
                                        <span class="text-danger">{{ $message }}</span>

                                        <style>
                                            .apellido {
                                                color: red;
                                            }
                                            </style>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Tipo de Calle -->
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="email" class="col-sm-12 col-form-label">Email</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.lazy="email" class="form-control"
                                            name="email" id="email" placeholder="Email">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>

                                            <style>
                                                .tipoCalle {
                                                    color: red;
                                                }
                                            </style>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="telefono" class="col-sm-12 col-form-label">Télefono</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.lazy="telefono" class="form-control" name="telefono"
                                            id="telefono" placeholder="Télefono">
                                        @error('telefono')
                                            <span class="text-danger">{{ $message }}</span>

                                            <style>
                                                .calle {
                                                    color: red;
                                                }
                                            </style>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- CP -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="codigoPostal" class="col-sm-12 col-form-label">CP</label>
                                    <div class="col-sm-12">
                                        <input type="number" wire:model.lazy="codigoPostal" class="form-control"
                                            name="codigoPostal" id="codigoPostal" placeholder="XXXXX">
                                        @error('codigoPostal')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>
                                                .codigoPostal {
                                                    color: red;
                                                }
                                            </style>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Ciudad -->
                                <div class="col-md-6">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">Direccion</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.lazy="direccion" class="form-control"
                                            name="direccion" id="direccion" placeholder="direccion">
                                        @error('direccion')
                                            <span class="text-danger">{{ $message }}</span>

                                            <style>
                                                .ciudad {
                                                    color: red;
                                                }
                                            </style>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                                <!-- poblacion -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="poblacion" class="col-sm-12 col-form-label">Poblacion</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.lazy="poblacion" class="form-control"
                                            name="poblacion" id="poblacion" placeholder="poblacion">
                                        @error('poblacion')
                                            <span class="text-danger">{{ $message }}</span>

                                            <style>
                                                .provincia {
                                                    color: red;
                                                }
                                            </style>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Provincia -->
                                <div class="col-md-6">
                                    <label for="provincia" class="col-sm-12 col-form-label">Provincia</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.lazy="provincia" class="form-control"
                                            name="provincia" id="provincia" placeholder="Provincia">
                                        @error('provincia')
                                            <span class="text-danger">{{ $message }}</span>

                                            <style>
                                                .provincia {
                                                    color: red;
                                                }
                                            </style>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="referido_id" class="col-sm-12 col-form-label">Referido</label>
                                    <div class="col-sm-12" wire:ignore>
                                        <select data-pharaonic="select2"
                                                data-component-id="{{ $this->id }}"
                                                class="form-control"
                                                wire:model="referido_id"
                                                data-placeholder="Referido"
                                                data-clear>
                                            <option value="">Seleccione</option>
                                            @foreach ($pacientes as $paciente)
                                                <option value={{$paciente->id}}>{{$paciente->nombre}} {{$paciente->apellido}}</option>
                                            @endforeach
                                        </select>
                                        @error('referido_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="empresa_id" class="col-sm-12 col-form-label">Empresa</label>
                                    <div class="col-sm-12" wire:ignore>
                                        <select data-pharaonic="select2"
                                                data-component-id="{{ $this->id }}"
                                                class="form-control"
                                                wire:model="empresa_id"
                                                data-placeholder="Empresa"
                                                data-clear>
                                            <option value="">Seleccione</option>
                                            @foreach ($empresas as $empresa)
                                            <option value={{$empresa->id}}>{{$empresa->nombre}}</option>
                                            @endforeach
                                        </select>
                                        @error('empresa_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="aseguradora_id" class="col-sm-12 col-form-label">Aseguradora</label>
                                    <div class="col-sm-12" wire:ignore>
                                        <select data-pharaonic="select2"
                                                data-component-id="{{ $this->id }}"
                                                class="form-control"
                                                wire:model="aseguradora_id"
                                                data-placeholder="Aseguradora"
                                                data-clear>
                                            <option value="">Seleccione</option>
                                            @foreach ($aseguradoras as $aseguradora)
                                            <option value={{$aseguradora->id}}>{{$aseguradora->nombre}}</option>
                                            @endforeach
                                        </select>
                                        @error('aseguradora_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="origen" class="col-sm-12 col-form-label">Origen</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model="origen" class="form-control"
                                            name="origen" id="origen" placeholder="Web/RR.SS/...">
                                        @error('origen')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>
                                                .provincia {
                                                    color: red;
                                                }
                                            </style>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 d-inline-flex align-items-center ms-5">
                                    <input class="form-check-input mt-0" wire:model.lazy="newsletter" type="checkbox"
                                        name="newsletter" id="newsletter">
                                    <label for="confPostal" class="col-form-label">¿Newsletter?</label>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                Cliente</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $("#alertaGuardar").on("click", () => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Pulsa el botón de confirmar para guardar el cliente.',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('submit');
                }
            });
        });

    </script>
@endsection
