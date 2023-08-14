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



<div class="container mx-auto">
    <h1>Semana X</h1>
    <h2>Resumen Semanal</h2>
    <br>

    <form wire:submit.prevent="submit">
        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ csrf_token() }}">


        <div class="container-md ">




            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Selecciona un dia</span>
                <input type="text" name="dia" class="form-control" placeholder="15/02/2023" id="dia"
                    wire:change="loadMonth">

            </div>



            <select class="form-control" name="i_semana" required id="i_semana" wire:model="i_semana">
                <option value="">Semana</option>
                @foreach ($semanas as $index => $semana)
                    <option value="{{ $index }}">
                        {{ $index }}</option>
                @endforeach

            </select>
            @if ($i_semana != null)


                    @if ($semana != null)
                        <div class="container-fluid">

                            <div>
                                {{-- {{ dd($semanas[$i_semana]) }} --}}
                                @foreach ($semanas[$i_semana] as $i => $dia)
                                    <div>
                                        @livewire('resumen-semanas.show-dia-component', ['dia' => $i], key($i))
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
            @endif
        </div>

        <br>
        <br>



    </form>


</div>





</div>

</tbody>
</table>
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

        });
        console.log('select2')
        $('.form-control select').select2();


        $("#dia").datepicker();


        $("#dia").on('change', function(e) {
            @this.set('day', $('#dia').val());
            @this.emit("loadMonth");
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

        //observer para aplicar el datepicker de evento
        const observer = new MutationObserver((mutations, observer) => {
            console.log(mutations, observer);
        });
        observer.observe(document, {
            subtree: true,
            attributes: true
        });



        document.addEventListener('DOMSubtreeModified', (e) => {

        })
    </script>
@endsection
