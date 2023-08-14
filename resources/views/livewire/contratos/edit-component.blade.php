@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
    <style>
        h2 {
            display: inline-block;
            margin-right: 5%;

        }

        h3,
        .editar,
        .guardar {
            margin-right: 5%;

        }
    </style>
@endsection

{{-- {{ var_dump($telefono) }} --}}

<div class="container mx-auto">
    <h1>Contratos</h1>
    <h2>Crear Contrato</h2>
    <br>

    {{-- {{ var_dump($clienteExistente) }}
    {{ var_dump($solicitante) }}
    {{ var_dump($id_servicio) }}
    {{ var_dump($addDiscount) }}
    {{ var_dump($metodoPago) }}
    {{ var_dump($isTransferencia) }} --}}
    <form wire:submit.prevent="submit">
        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ csrf_token() }}">


        <div class="container-md ">
            <div class="container-md text-center">
                <h2>Contrato Servicios</h2>
                <br>
            </div>
            <div class="input-group mb-3">
                <br>
                <span class="input-group-text">Contrato Nº</span>
                <div class="col-md-2">
                    <input type="text" wire:model="nContrato" class="form-control" name="nContrato" id="nContrato"
                        placeholder="X" required>
                    @error('nContrato')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <span class="input-group-text">Dia del evento</span>
                <div class="col-md-2">
                    <input type="text" wire:model="diaEvento" class="form-control" name="diaEvento" id="diaEvento"
                        placeholder="X">
                    @error('diaEvento')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <span class="input-group-text">Presupuesto Nº</span>
                <div class="col-md-2">

                    <select class="form-control select" name="id_presupuesto" id="id_presupuesto"
                        wire:model="id_presupuesto">
                        <option value="">Nº Presupuesto</option>
                        @foreach ($presupuestos as $presupuesto)
                            <option value="{{ $presupuesto->id }}" 
                                wire:click="loadPresupuesto">
                                {{ $presupuesto->id }}
                            </option>
                        @endforeach
                        {{-- @error('id_cliente')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror --}}
                    </select>

                    {{-- <input type="text" wire:model="id_presupuesto" class="form-control" name="id_presupuesto" id="id_presupuesto"
                        placeholder="X" required> --}}
                    {{-- @error('nContrato')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror --}}

                </div>
                {{-- <button type="button" class="btn btn-outline-info editar" wire:click="loadPresupuesto">Buscar presupuesto
                    </button> --}}
            </div>


        </div>

        <div>
            @if ($id_presupuesto != 0)
                <div>
                    @livewire('presupuestos.contract-component', ['identificador' => $id_presupuesto], key($id_presupuesto))
                </div>
            
        </div>


        <div class="input-group mb-3">
            @error('metodosPago')
                <style>
                    .metodosPago {
                        color: red;
                    }
                </style>
            @enderror
            <span class="input-group-text metodosPago">Metodo de pago*:</span>
            <select class="input-group-text" name="metodosPago" required id="metodosPago" wire:model="metodoPago">
                <option class="dropdown-item" value="">Metodo de pago</option>
                @foreach ($metodosPago as $metodo)
                    <option class="dropdown-item" wire:click="isTransferencia" value="{{ $metodo->id }}">
                        {{ $metodo->nombre }}
                    </option>
                @endforeach
                {{-- @error('metodo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror --}}
            </select>
            @if ($isTransferencia)
                @error('cuentaTransferencia')
                    <style>
                        .cuentaTransferencia {
                            color: red;
                        }
                    </style>
                @enderror
                <span class="input-group-text cuentaTransferencia">Cuenta*</span>
                <select class="input-group-text" name="cuentaBanco" required id="cuentaBanco"
                    wire:model="cuentaTransferencia">
                    <option class="dropdown-item" value="">Cuenta</option>
                    @foreach ($cuentas as $cuenta)
                        <option class="dropdown-item" wire:click="" value="{{ $cuenta->id }}">
                            {{ $cuenta->cuenta }}
                        </option>
                    @endforeach
                    {{-- @error('metodo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror --}}
                </select>

            @endif
            @endif
        </div>

</div>
<br>
{{-- @endif --}}


{{-- consentimiento --}}
@if ($metodoPago)
    <div class="container-md ">
        <div class="container-md text-center">
            <h2 class="text-center">CONSENTIMIENTO TRATAMIENTO DE DATOS DE CARÁCTER PERSONAL</h2>
        </div>
        <br>
        <div class="input-group mb-3">
            <div class="col">
                <div class="input-group has-validation">
                    @error('responsableTratamiento')
                        <style>
                            .responsableTratamiento {
                                color: red;
                            }
                        </style>
                    @enderror
                    <span class="input-group-text responsableTratamiento">Identidad del responsable de
                        tratamiento:</span>
                    <input type="text" wire:model="responsableTratamiento" class="form-control"
                        name="responsableConsentimiento" required id="responsableConsentimiento" placeholder="">

                </div>
            </div>
        </div>
        <p>
            <strong>{{ $empresa->nombre }}</strong><br>
            <span>{{ $empresa->cif }}</span><br>
            <span>{{ $empresa->cod_postal . ' ' . $empresa->direccion }}</span><br>
            <span>{{ number_format($empresa->telefono1, 0, ',', ' ') }}</span><span>{{ number_format($empresa->telefono1, 0, ',', ' ') }}</span><br>
            <span>{{ $empresa->email }}</span>
        </p>
        <p>
            {{ $empresa->legal1 }}
        </p>
        <p>
            {{ $empresa->legal2 }}
        </p>
        <p>
            {{ $empresa->legal3 }}
        </p>
        <p>
            {{ $empresa->legal4 }}
        </p>

        <strong>INDIQUE CON SI/NO LA SIGUIENTE AUTORIZACION:</strong><br>
        <div class="input-group mb-3">
            <span class="input-group-text">Autorizo la captación y difusión de imágenes en medios
                propios.</span>
            <select class="input-group-text" name="authImagen" required id="authImagen" wire:model="authImagen">
                <option class="dropdown-item" value="{{ 0 }}">SI/NO
                </option>
                <option class="dropdown-item" value="{{ 0 }}">NO
                </option>
                <option class="dropdown-item" value="{{ 1 }}">SI
                </option>
                @error('authImagen')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </select>
        </div>
        @if ($authImagen)
            <div class="input-group mb-3">
                <span class="input-group-text">En caso afirmativo, deseo que se muestren los rostros de
                    los
                    menores. </span>
                <select class="input-group-text" name="authMenores" required id="authMenores" wire:model="authMenores">
                    <option class="dropdown-item" value="{{ 0 }}">SI/NO
                    </option>
                    <option class="dropdown-item" value="{{ 0 }}">NO
                    </option>
                    <option class="dropdown-item" value="{{ 1 }}">SI
                    </option>
                    @error('authMenores')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </select>
            </div>
        @endif
        <p>
            Podrá ejercitar su derecho a solicitar el acceso a sus datos, la rectificación o supresión,
            la
            limitación del tratamiento, la oposición del tratamiento o la portabilidad de los datos,
            dirigiendo un escrito junto a la copia de su DNI a en la siguiente dirección:
        </p>
        <p>
            En caso de disconformidad, Vd. tiene derecho a elevar una reclamación ante la Agencia
            Española
            de Protección de Datos (www.agpd.es).
        </p>
        <p>
            He sido informado y autorizo expresamente el tratamiento, con la firma de este contrato.
        </p>
    </div>

    <style>
        .firmas {
            margin: 15px;
            width: 750px;
            height: 200px;
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div class="container-md text-center">
        <h2>FIRMA Y CONFORMIDAD</h2>
        <h3>{{ $this->fechaContratoFormat() }}</h3>
        {{-- <div class="row">
                    <div class="col">
                        <span>Solicitante</span><br>
                        <img class="firmas "src="{{ asset('assets/55336-img.jpg') }}" alt="Firma del Solicitante" width="200" height="200">
                    </div>
                    <div class="col">
                        <span>La Fábrica</span><br>
                        <img class="firmas "src="{{ asset('assets/55336-img.jpg') }}" alt="Firma del Solicitante" width="200" height="200">
                    </div>
                </div> --}}
        <table>
            <thead>
                <th class="firmasHead">Solicitante</th>
                <th class="firmasHead">La Fábrica</th>
            </thead>
            <tbody>
                <tr>
                    <td class="firmas"></td>
                    <td class="firmas"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>
    <br>


    <div class="mb-3 row d-flex align-items-center">
        <button type="button" wire:click="submit" class="btn btn-outline-info">Guardar Contrato</button>
    </div>
@endif

</form>


</div>





</div>

</tbody>
</table>
@section('scripts')
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
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
            $('#tableServicios').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                buttons: [{
                    extend: 'collection',
                    text: 'Export',
                    buttons: [{
                            extend: 'pdf',
                            className: 'btn-export'
                        },
                        {
                            extend: 'excel',
                            className: 'btn-export'
                        }
                    ],
                    className: 'btn btn-info text-white'
                }],
                "language": {
                    "lengthMenu": "Mostrando _MENU_ registros por página",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Mostrando página _PAGE_ of _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ total registros)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "zeroRecords": "No se encontraron registros coincidentes",
                }
            });
            console.log('select2')
            $('.form-control select').select2();
            $("#diaEvento").datepicker();


            $("#diaEvento").on('change', function(e) {
                @this.set('diaEvento', $('#diaEvento').val());
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
