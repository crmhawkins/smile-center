
{{-- {{ var_dump($eventoServicios) }} --}}
<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CLIENTE <span style="text-transform: uppercase">{{$nombre}}</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Clientes</a></li>
                    <li class="breadcrumb-item active">Cliente {{$nombre}}</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form class="" wire:submit.prevent="update">
                    {{-- <form class="row g-3" wire:submit.prevent="update"> --}}
                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">

                        <!-- Tratamiento -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Tratamiento</label>
                            <div class="col-sm-10">
                                <select class="input-group-text" name="trato" required id="trato" wire:model="trato">
                                    <option class="dropdown-item" value="" disabled>Trato</option>
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
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                {{-- <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"> --}}
                                <input type="text" wire:model="nombre" class="form-control" name="nombre" id="nombre"
                                aria-label="Nombre" placeholder="Nombre">
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>

                        <!-- Apellido -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Apellido</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="apellido" class="form-control" name="apellido" id="apellido"
                                placeholder="Apellido">
                            @error('apellido')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>

                        <!-- NIF/DNI -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">NIF/DNI</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="nif" class="form-control" name="nif" id="nif"
                                    placeholder="Nif">
                            @error('nif')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>

                        <!-- Tipo de Calle -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Tipo de Calle</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="tipoCalle" class="form-control" name="tipoCalle" id="tipoCalle"
                                    placeholder="Avenida/Plaza/Calle...">
                            @error('tipoCalle')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                        
                        <!-- Via -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Via</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="calle" class="form-control" name="calle" id="calle"
                                    placeholder="Calle">
                            @error('calle')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
            
                         <!-- Nº -->
                         <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nº</label>
                            <div class="col-sm-10">
                                <input type="number" wire:model="numero" class="form-control" name="numero" id="numero"
                                        placeholder="1">
                                @error('numero')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr/>

                        <!-- Dir Adi 1 -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Dir Adi 1</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="direccionAdicional1" class="form-control"
                                    name="direccionAdicional1" id="direccionAdicional1" placeholder="Bloque/Letra...">
                            </div>
                        </div>

                        <!-- Dir Adi 2 -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Dir Adi 2</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="direccionAdicional2" class="form-control"
                                    name="direccionAdicional2" id="direccionAdicional2" placeholder="Bloque/Letra...">
                            </div>
                        </div>

                        <!-- Dir Adi 3 -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Dir Adi 3</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="direccionAdicional3" class="form-control"
                                    name="direccionAdicional3" id="direccionAdicional3" placeholder="Bloque/Letra...">
                            </div>
                        </div>

                        <!-- CP -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">CP</label>
                            <div class="col-sm-10">
                                <input type="number" wire:model="codigoPostal" class="form-control" name="codigoPostal"
                                    id="codigoPostal" placeholder="XXXXX">
                                @error('codigoPostal')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Ciudad -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Ciudad</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="ciudad" class="form-control" name="ciudad" id="ciudad"
                                    placeholder="Ciudad">
                                @error('ciudad')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirmacion Postal -->
                        <div class="form-group row">
                            <label for="confPostal" class="col-sm-2 col-form-label">Confirmacion Postal</label>
                            <div class="col-sm-10">
                                <input class="form-check-input mt-0" wire:model="confPostal" type="checkbox" value="" name="confPostal" id="confPostal"
                                aria-label="Checkbox for following text input">
                                {{-- <span class="input-group-text">Confirmacion Postal</span> --}}
                            </div>
                        </div>

                        <!-- Telefono -->
                        <div class="form-group row">
                            <label for="tlf1" class="col-sm-2 col-form-label">Telefono</label>
                            <div class="col-sm-10">
                                <input type="number" wire:model="tlf1" class="form-control" name="tlf1" id="tlf1"
                                    placeholder="XXXXXXXXX">
                                @error('tlf1')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Telefono Secundario -->
                        <div class="form-group row">
                            <label for="tlf2" class="col-sm-2 col-form-label">Telefono Secundario</label>
                            <div class="col-sm-10">
                                <input type="number" wire:model="tlf2" class="form-control" name="tlf2" id="tlf2"
                                    placeholder="Opcional">
                            </div>
                        </div>

                        <!-- Telefono Adicional -->
                        <div class="form-group row">
                            <label for="tlf3" class="col-sm-2 col-form-label">Telefono Adicional</label>
                            <div class="col-sm-10">
                                <input type="number" wire:model="tlf3" class="form-control" name="tlf3" id="tlf3"
                                    placeholder="Opcional">
                            </div>
                        </div>

                        <!-- Confirmacion SMS -->
                        <div class="form-group row">
                            <label for="confSms" class="col-sm-2 col-form-label">Confirmacion SMS</label>
                            <div class="col-sm-10">
                                <input class="form-check-input mt-0" wire:model="confSms" type="checkbox" value="" id="confSms"
                                        aria-label="Checkbox for following text input">
                            </div>
                        </div>

                        <hr/>

                        <!-- Email -->
                        <div class="form-group row">
                            <label for="email1" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="email1" class="form-control" name="email1" id="email1"
                                    placeholder="Email@email.com">
                                @error('email1')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Secundario -->
                        <div class="form-group row">
                            <label for="email1" class="col-sm-2 col-form-label">Email Secundario</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="email2" class="form-control" name="email2" id="email2"
                                    placeholder="email@email.com">
                            </div>
                        </div>

                        <!-- Email Adicional -->
                        <div class="form-group row">
                            <label for="email1" class="col-sm-2 col-form-label">Email Adicional</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="email3" class="form-control" name="email3" id="email3"
                                    placeholder="Email@email.com">
                            </div>
                        </div>

                        <!-- Confirmacion Email -->
                        <div class="form-group row">
                            <label for="confEmail" class="col-sm-2 col-form-label">Confirmacion Email</label>
                            <div class="col-sm-10">
                                <input class="form-check-input mt-0" wire:model="confEmail" type="checkbox" value="" id="confEmail"
                                        aria-label="Checkbox for following text input">
                            </div>
                        </div> 
                        
                        <div class="form-group row mt-3">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Guardar</button>
                            <button wire:click="destroy" class="btn btn-danger btn-lg waves-effect waves-light mt-2">Eliminar</button>
                        </div> 
               
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    @section('scripts')
    <script src="../assets/js/jquery.slimscroll.js"></script>

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
                dateFormat: 'dd/mm/yy',
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
                $("#datepicker").datepicker();

                $("#datepicker").on('change', function(e) {
                    @this.set('fecha_nac', $('#datepicker').val());
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

