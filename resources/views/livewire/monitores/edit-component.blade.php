@section('head')
    @vite(['resources/sass/productos.scss'])
@endsection
<div class="container mx-auto">
    <h1>Monitores</h1>
    <h2>Editar monitor</h2>
    <br>
    <form wire:submit.prevent="update">
        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">

        <div class="input-group mb-3">
            <span class="input-group-text">Nombre</span>
            <div class="col-md-3">
                <input type="text" wire:model="nombre" class="form-control" name="nombre" id="nombre"
                    placeholder="José Carlos...">
                @error('nombre')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <span class="input-group-text">Apellidos</span>
            <div class="col-md-3">
                <input type="text" wire:model="apellidos" class="form-control" name="apellidos" id="apellidos"
                    placeholder="Pérez...">
                @error('apellidos')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <span class="input-group-text">Fecha de nacimiento</span>
            <div class="col-md-2">
                <input type="date-local" wire:model.defer="fechaNa" class="form-control" placeholder="15/02/2023"
                    id="datepicker">
                @error('fechaNa')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Localidad</span>

            <div class="col-md-5">
                <input type="text" wire:model="localidad" class="form-control" name="localidad" id="localidad"
                    placeholder="Localidad">
                @error('localidad')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <span class="input-group-text">Telefono</span>
            <div class="col-md-4">
                <input type="text" wire:model="telefono" class="form-control" name="telefono" id="telefono"
                    placeholder="123456...">
                @error('telefono')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>
        @if (count($programas) > 0)
            <table class="table" id="tableMonitor">
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Servicio</th>
                        <th>Fecha</th>
                        <th>Coste</th>
                        <th>Pagado</th>
                        <th>Por pagar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($programas as $programa)
                    <tr>
                        <td>{{ $this->getEventoFromIdServicioEvento($programa->id_servicioEvento) }}</td>
                        <td>{{ $this->getServicioFromIdServicioEvento($programa->id_servicioEvento) }}</td>
                        <td>{{ $programa->dia }}</td>
                        <td>{{ $programa->precioMonitor }}€</td>
                        <td>{{ $programa->pagado ?? 0 }}€</td>
                        <td>{{ $programa->precioMonitor - $programa->pagado ?? 0 }}€</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <h3>Este monitor no ha realizado ningun trabajo</h3>
        @endif


        <div class="mb-3 row d-flex align-items-center">
            <button type="submit" class="btn btn-outline-info">Guardar</button>
        </div>


    </form>
    <div class="mb-3 row d-flex align-items-center">
        <button wire:click="destroy" class="btn btn-outline-danger">Eliminar</button>
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
            $("#datepicker").datepicker();

            $("#datepicker").on('change', function(e) {
                @this.set('fechaNa', $('#datepicker').val());
            });

            console.log('entro');
            $('#tableMonitor').DataTable({
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

            addEventListener("resize", (event) => {
                location.reload();
            })

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
