<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR EVENTOS</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Eventos</a></li>
                    <li class="breadcrumb-item active">Crear Evento</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="form-group row">

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Dia comienzo</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model="diaEvento" class="form-control" name="diaEvento" id="diaEvento"
                                    placeholder="X">
                                    @error('diaEvento')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Dia fin</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model="diaFinal" class="form-control" name="diaFinal" id="diaFinal"
                                    placeholder="X">
                                    @error('diaFinal')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Evento</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model="eventoNombre" class="form-control" name="eventoNombre" id="eventoNombre"
                                placeholder="Evento">
                                    @error('eventoNombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Protagonistas</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model="eventoProtagonista" class="form-control" name="eventoProtagonista"
                                    id="eventoProtagonista" placeholder="Protagonistas">
                                    @error('eventoProtagonista')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Nª Niños</label>
                                <div class="col-sm-10">
                                    <input type="number" wire:model="eventoNiños" class="form-control" name="eventoNiños" id="eventoNiños"
                                    placeholder="0">
                                    @error('eventoNiños')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Nª Adultos</label>
                                <div class="col-sm-10">
                                    <input type="number" wire:model="eventoAdultos" class="form-control" name="eventoAdultos" id="eventoAdultos"
                                    placeholder="0">
                                    @error('eventoAdultos')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Contacto</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model="eventoContacto" class="form-control" name="eventoContacto"
                                id="eventoContacto" placeholder="Contacto">
                                    @error('eventoContacto')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Parentesco</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model="eventoParentesco" class="form-control" name="eventoParentesco"
                                    id="eventoParentesco" placeholder="Parentesco">
                                    @error('eventoParentesco')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Telefono</label>
                                <div class="col-sm-10">
                                    <input type="number" wire:model="eventoTelefono" class="form-control" name="eventoTelefono"
                                id="eventoTelefono" placeholder="Telefono">
                                    @error('eventoTelefono')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Lugar</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model="eventoLugar" class="form-control" name="eventoLugar" id="eventoLugar"
                                    placeholder="Lugar">
                                    @error('eventoLugar')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Localidad</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model="eventoLocalidad" class="form-control" name="eventoLocalidad"
                                id="eventoLocalidad" placeholder="Localidad">
                                    @error('eventoLocalidad')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confMontaje" class="col-sm-2 col-form-label">Posibilidad de Montaje</label>
                                <div class="col-sm-10">
                                    <input class="form-check-input mt-0" wire:model="eventoMontaje" type="checkbox" value="" id="confMontaje"
                                    aria-label="Checkbox for following text input">
                                </div>
                            </div>
                            
                        </div>
                
                        <div class="mb-3 row d-flex align-items-center">
                            <button type="submit"  class="btn btn-primary btn-lg waves-effect waves-light">Guardar</button>
                        </div>
                
                
                    </form>
                </div>
            </div>
        </div>
    </div>
    


</div>

@section('scripts')

    <script>
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
        document.addEventListener('livewire:load', function() {


        })
        $(document).ready(function() {
            console.log('select2')
            $("#diaEvento").datepicker();
            $("#diaFinal").datepicker();
            $("#dia").datepicker();

            $("#diaEvento").on('change', function(e) {
                @this.set('diaEvento', $('#diaEvento').val());
                @this.set('diaFinal', $('#diaEvento').val());

            });

            $("#diaFinal").on('change', function(e) {
                @this.set('diaFinal', $('#diaFinal').val());
            });

            $("#dia").on('change', function(e) {
                @this.set('dia', $('#dia').val());
            });

        });

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
    </script>
@endsection
