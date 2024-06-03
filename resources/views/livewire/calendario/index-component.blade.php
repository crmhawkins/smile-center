<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CALENDARIO</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Calendario</a></li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <style>
                        .tooltip-inner {
                            text-align: left !important;
                        }
                    </style>


                    <div id='calendar' class="w-100"></div>
                    <button class="btn btn-secondary w-100 mb-4 mt-4" onclick="savePDF()"
                        id="export-pdf-button">Exportar a PDF</button>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>


@section('scripts')
    @php use Carbon\Carbon; @endphp
    <!-- Required datatable js -->
    {{-- <script src="../assets/js/jquery.min.js"></script> --}}
    <script src="../assets/js/jquery.slimscroll.js"></script>

    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="../plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/datatables/jszip.min.js"></script>
    <script src="../plugins/datatables/pdfmake.min.js"></script>
    <script src="../plugins/datatables/vfs_fonts.js"></script>
    <script src="../plugins/datatables/buttons.html5.min.js"></script>
    <script src="../plugins/datatables/buttons.print.min.js"></script>
    <script src="../plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="../plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script src="../assets/pages/datatables.init.js"></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://superal.github.io/canvas2image/canvas2image.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var appUrl = "{{ config('app.url') }}";
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: "es",
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // user can switch between the two
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                events: [
                    @foreach ($citas as $cita)
                    {
                        title: '{{ $this->pacientes->where('id', $cita->paciente_id)->first()->nombre }} ',
                        start: '{{ $cita->fecha }}',
                        end: '{{ $cita->fecha }}',
                        id: '{{ $cita->id }}',
                        html: true,
                        @if (isset($cita->presupuesto()->first()->id))
                        description: '<br> <b>Nº Presupuesto:</b> {{ $cita->presupuesto()->first()->id }}<br> <b>Observacion:</b> {{ $cita->observacion }}',
                        presupuestoId: '{{ $cita->presupuesto()->first()->id }}',
                        @else
                        citaid: '{{ $cita->id }}',
                        description: '<br> <b>Observacion:</b> {{ $cita->observacion }}',
                        @endif
                        color: '#02C58D',
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    if (info.event.extendedProps.presupuestoId != undefined) {
                        console.log('hola');
                        window.open(appUrl + '/admin/presupuestos-edit/' + info.event.extendedProps.presupuestoId);
                    }
                    if (info.event.extendedProps.citaid != undefined) {
                        console.log('hola');
                        window.open(appUrl + '/admin/citas-edit/' + info.event.extendedProps.citaid);
                    }
                },
                eventDidMount: function(info) {
                    var tooltip = new bootstrap.Tooltip(info.el, {
                        title: '<h5>' + info.event.title + '</h5>' + info.event.extendedProps
                            .description,
                        placement: 'top',
                        trigger: 'hover',
                        html: true
                    });
                },
            });
            calendar.render();

        });

        function savePDF() {

            html2canvas($('#calendar')[0]).then(function(canvas) {
                var doc = new jsPDF();
                var img = Canvas2Image.convertToPNG(canvas);
                doc.setProperties({
                    title: 'Eventos',
                    subject: 'Info about PDF',
                    author: 'PDFAuthor',
                    keywords: 'generated, javascript, web 2.0, ajax',
                    creator: 'My Company'
                });
                doc.setFontSize(22);
                doc.text(15, 20, 'Eventos');
                doc.addImage(img, 'PNG', 15, 40, 180, 160);
                doc.save('div.pdf');
                //   $(".response").append(canvas);
            })

        }
    </script>
@endsection
