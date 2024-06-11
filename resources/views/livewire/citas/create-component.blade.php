<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR CITA</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Citas</a></li>
                    <li class="breadcrumb-item active">Crear Cita</li>
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
                                Datos de la cita</h5>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="presupuesto_id" class="col-sm-12 col-form-label">Presupuesto asociado</label>
                                    <div class="col-sm-12" wire:ignore>
                                        <select data-pharaonic="select2"
                                                data-component-id="{{ $this->id }}"
                                                class="form-control"
                                                wire:model="presupuesto_id"
                                                id="presupuesto_id"
                                                data-placeholder="presupuesto"
                                                data-clear>
                                            <option value={{null}}>Seleccione</option>
                                            @foreach ($presupuestos as $presupuesto)
                                            <option value={{$presupuesto->id}}>{{$presupuesto->id}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="paciente_id" class="col-sm-12 col-form-label">Paciente</label>
                                    <div class="col-sm-12" wire:ignore>
                                        <select data-pharaonic="select2"
                                                data-component-id="{{ $this->id }}"
                                                class="form-control"
                                                wire:model="paciente_id"
                                                id="paciente_id"
                                                data-placeholder="paciente"
                                                data-clear>
                                            <option value={{null}}>Seleccione</option>
                                            @foreach ($pacientes as $paciente)
                                                <option value={{$paciente->id}}>{{$paciente->nombre}} {{$paciente->apellido}}</option>
                                            @endforeach
                                        </select>
                                        @error('paciente_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Tipo de Calle -->
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="fecha" class="col-sm-12 col-form-label">Fecha</label>
                                    <div class="col-sm-12">
                                        <input type="date" wire:model.lazy="fecha" class="form-control"
                                            name="fecha" id="fecha" placeholder="fecha">
                                        @error('fecha')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>
                                                .text-danger {
                                                    color: red;
                                                }
                                            </style>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="hora" class="col-sm-12 col-form-label">Hora</label>
                                    <div class="col-sm-12">
                                        <input type="time" wire:model.lazy="hora" class="form-control" name="hora"
                                            id="hora" placeholder="Hora">
                                    </div>
                                </div>
                            </div>
                            <!-- Observacion -->
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="observacion" class="col-sm-12 col-form-label">Observaciones</label>
                                    <div class="col-sm-12">
                                        <textarea  wire:model.lazy="observacion" class="form-control"
                                            name="observacion" id="observacion" placeholder="Observaciones">
                                        </textarea>
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
                            <button class="w-100 btn btn-success mb-2" id="alertaGuardar">Guardar Cita</button>
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
            togglePacienteId();

            Livewire.hook('message.processed', (message, component) => {
                togglePacienteId();
            });
        });

        function togglePacienteId() {
            var presupuestoIdValue = $('#presupuesto_id').val();
            var pacienteId = $('#paciente_id');

            if (presupuestoIdValue) {
                if (!pacienteId.prop('disabled')) {
                    pacienteId.prop('disabled', true).trigger('change');
                }
            } else {
                if (pacienteId.prop('disabled')) {
                    pacienteId.prop('disabled', false).trigger('change');
                }
            }
        }
        $("#alertaGuardar").on("click", () => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Pulsa el botón de confirmar para guardar la cita.',
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

