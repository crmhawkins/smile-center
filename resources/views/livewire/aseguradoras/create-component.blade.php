<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR ASEGURADORA</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Aseguradoras</a></li>
                    <li class="breadcrumb-item active">Crear Aseguradora</li>
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
                                Datos de la aseguradora</h5>
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
                                <div class="col-md-6">
                                    <label for="plataforma_id" class="col-sm-12 col-form-label">Plataforma</label>
                                    <div class="col-sm-12" wire:ignore>
                                        <select data-pharaonic="select2"
                                                data-component-id="{{ $this->id }}"
                                                class="form-control"
                                                wire:model="plataforma_id"
                                                data-placeholder="Plataforma"
                                                data-clear>
                                            <option value="">Seleccione</option>
                                            @foreach ($plataformas as $plataforma)
                                            <option value={{$plataforma->id}}>{{$plataforma->nombre}}</option>
                                            @endforeach
                                        </select>
                                        @error('plataforma')
                                            <span class="text-danger">{{ $message }}</span>
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
                                Aseguradora</button>
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

