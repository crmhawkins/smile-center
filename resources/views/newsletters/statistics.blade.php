@extends('layouts.app')

@section('content-principal')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<div id="content" class="container-fluid">
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de usuario</a>
            </li>
            <li class="breadcrumb-item active">Marketing</li>
        </ol>
        <div class="row">
            <div class="col">
                <h3>
                    Marketing
                    <a href="#" class="btn btn-outline-light">
                        <i class="icon-plus icons icon_l"></i> Añadir campaña de marketing
                    </a>
                </h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="block block-rounded">
                <div class="block-header">
                  <h3 class="block-title"> Abiertas</h3>
                </div>
                <div class="block-content block-content-full">
                    <canvas id="graphic_one" height="480" width="600"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="block block-rounded">
                <div class="block-header">
                  <h3 class="block-title"> Enviadas</h3>
                </div>
                <div class="block-content block-content-full">
                    <canvas id="graphic_two" height="480" width="600"></canvas>
                </div>
            </div>
        </div>
       <div class="col-md-4">
            <div class="block block-rounded">
                <div class="block-header">
                  <h3 class="block-title"> Bajas</h3>
                </div>
                <div class="block-content block-content-full">
                    <canvas id="graphic_three" height="480" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="block block-rounded">
                <div class="block-header">
                  <h3 class="block-title">NEWSLETTERS ACTIVAS</h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-4">
                            <label for=""><strong>Selecciona la Newsletter</strong></label>
                            <select class="newsletters" name="newsletter">
                                <option selected disabled>Seleccionar</option>
                                @if($newsletters)
                                    @foreach($newsletters as $newsletter)
                                        <option value="{{$newsletter->id}}">{{$newsletter->first_title_newsletter}} - {{$newsletter->date_sent}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-4">
                            <label for=""><strong>Desde</strong></label>
                            <input type="date" class="date-range-filter" id="from_date" name="from_date">
                        </div>
                        <div class="col-4">
                            <label for=""><strong>Hasta</strong></label>
                            <input type="date" class="date-range-filter" id="end_date" name="end_date">
                        </div>
                    </div>
                     <table class="table table-hover table-striped table-bordered table-statisctics" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Campaña</th>
                                <th>Email</th>
                                <th>Enviado</th>
                                <th>Abierto</th>
                                <th>Número de veces abierto</th>
                                <th>Fecha envio</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous"></script>

<script type="text/javascript">

    $(document).ready(function(){
        graphicOne();
        graphicTwo();
        graphicThree();

        $('#from_date').datetimepicker({
            format: 'DD/MM/YYYY',
            //date: new Date()/
        });

        $('#end_date').datetimepicker({
            format: 'DD/MM/YYYY',
            //date: new Date()/
        });

        $('.newsletters').select2();

        var table = $('.table-statisctics').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('newsletters.getNewsletters') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'cliente', name: 'cliente' },
                { data: 'campaign', name: 'campaign' },
                { data: 'email', name: 'email' },
                { data: 'enviado', name: 'enviado' },
                { data: 'abierto', name: 'abierto' },
                { data: 'times_opened', name: 'times_opened' },
                { data: 'date_sent', name: 'date_sent' }
            ],
            "language":{
                "sEmptyTable":"No hay datos disponibles en la tabla",
                "sInfo":"Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "sInfoEmpty":"Mostrando 0 a 0 de 0 entradas",
                "sInfoFiltered":"(Filtrada de _MAX_ entradas totales)",
                "sInfoPostFix":"",
                "sInfoThousands":",",
                "sLengthMenu":"Mostrar _MENU_ entradas",
                "sLoadingRecords":"Cargando...",
                "sProcessing":"Procesando...",
                "sSearch":"Buscar:",
                "sZeroRecords":"No se encontraron registros coincidentes",
                "oPaginate":{
                    "sFirst":"Primero",
                    "sLast":"\u00daltimo",
                    "sNext":"Siguiente",
                    "sPrevious":"Anterior"
                    },
                    "oAria":{
                        "sSortAscending":": Activar para ordenar la columna ascendente",
                        "sSortDescending":": Activar para ordenar la columna descendente"
                    }
                },
            "columnDefs":[{
                "targets":-1,
                "searchable":false,
                "orderable":false
            }]
        });

        $('.date-range-filter').change(function() {
            var min  = $('#from_date').val();
            var max  = $('#end_date').val();
            var result = $('.newsletters').val();

            console.log(min+" - "+max+" ---- "+result);

            if(min && max && result){
                min = moment(new Date(min)).format('MM-DD-YYYY');
                max = moment(new Date(max)).format('MM-DD-YYYY');
                drawGraphics(result);

                table = $('.table-statisctics').DataTable({
                    destroy: true,
                    ajax : {
                        'headers': {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        'url' : '{{ route('newsletters.getNewslettersFilterDate') }}',
                        'data' : {
                            'min' : min,
                            'max': max,
                            'id': result
                        },
                        'type' : 'post'
                    },
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'cliente', name: 'cliente' },
                        { data: 'campaign', name: 'campaign' },
                        { data: 'email', name: 'email' },
                        { data: 'enviado', name: 'enviado' },
                        { data: 'abierto', name: 'abierto' },
                        { data: 'times_opened', name: 'times_opened' },
                        { data: 'date_sent', name: 'date_sent' }
                    ],
                    'order': []
                });


            }

        });

        $('.newsletters').change(function() {
            let result = $(this).val();
            table.ajax.url( 'https://crmhawkins.com/admin/newsletters/get-filter-newsletters/'+result ).load();
            drawGraphics(result);
        });

    });

    function drawGraphics(id){
        $.when( getInfoGraphics(id) ).then(function( data, textStatus, jqXHR ) {
            console.log(data);
            drawGraphicOne(data);
            drawGraphicTwo(data);
            drawGraphicThree(data);
        });
    }

    function getInfoGraphics(id){
        return  $.ajax({
            type: "POST",
            url: '{{route('marketing.getInfo')}}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                'id': id
            },
            dataType: "json"
        });
    }

    function drawGraphicOne(data){
        var newslettersList = data;

        var total_opened = 0;

       newslettersList.forEach( newsletter => {
            total_opened += newsletter['open']
        });

        $( document ).ready(function() {
            var ctx = document.getElementById("graphic_one").getContext("2d");
            var data = {
                labels: ['Abiertas'],
                datasets: [
                    {
                        data: [total_opened],
                        backgroundColor: [
                            'rgb(54, 162, 235)',
                        ]
                    },
                ]
            };

            var myBarChart = new Chart(ctx, {
                scaleStartValue: 0,
                type: 'doughnut',
                data: data,

            });
        });
    }

    function drawGraphicTwo(data){
        var newslettersList = data;

        var total_sent = 0;

        newslettersList.forEach( newsletter => {
            total_sent += newsletter['sent']
        });

        $( document ).ready(function() {
            var ctx = document.getElementById("graphic_two").getContext("2d");
            var data = {
                labels: ['Enviadas'],
                datasets: [
                    {
                        label: "Enviadas",
                        data: [total_sent],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                        ]
                    },
                ]
            };

            var myBarChart = new Chart(ctx, {
                scaleStartValue: 0,
                type: 'bar',
                data: data,

            });
        });
    }

    function drawGraphicThree(data){
        var newslettersList = data;

        var bajas = 0;

        newslettersList.forEach( newsletter => {
            bajas += newsletter['baja'];
        });

        $( document ).ready(function() {
            var ctx = document.getElementById("graphic_three").getContext("2d");
            var data = {
                labels: ['Bajas'],
                datasets: [
                    {
                        label: "Bajas",
                        data: [bajas],
                        backgroundColor: [
                            '#49BEAA',
                        ]
                    },
                ]
            };

            var myBarChart = new Chart(ctx, {
                scaleStartValue: 0,
                type: 'bar',
                data: data,

            });
        });
    }

    function graphicOne(){

        var newslettersList = @json($newsletters_actives);

        var total_opened = 0;
        var total_sent = 0;

       newslettersList.forEach( newsletter => {
            total_opened += newsletter['open']
        });

        $( document ).ready(function() {
            var ctx = document.getElementById("graphic_one").getContext("2d");
            var data = {
                labels: ['Abiertas'],
                datasets: [
                    {
                        data: [total_opened],
                        backgroundColor: [
                            '#67697C',
                        ]
                    },
                ]
            };

            var myBarChart = new Chart(ctx, {
                scaleStartValue: 0,
                type: 'doughnut',
                data: data,

            });
        });
    }

    function graphicTwo(){

        var newslettersList = @json($newsletters_actives);

        var total_sent = 0;

        newslettersList.forEach( newsletter => {
            total_sent += newsletter['sent']
        });

        $( document ).ready(function() {
            var ctx = document.getElementById("graphic_two").getContext("2d");
            var data = {
                labels: ['Enviadas'],
                datasets: [
                    {
                        label: "Enviadas",
                        data: [total_sent],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                        ]
                    },
                ]
            };

            var myBarChart = new Chart(ctx, {
                scaleStartValue: 0,
                type: 'bar',
                data: data,

            });
        });
    }

    function graphicThree(){
        var newslettersList = @json($newsletters_actives);

        var bajas = 0;

        newslettersList.forEach( newsletter => {
            bajas += newsletter['baja'];
        });

        $( document ).ready(function() {
            var ctx = document.getElementById("graphic_three").getContext("2d");
            var data = {
                labels: ['Bajas'],
                datasets: [
                    {
                        label: "Bajas",
                        data: [bajas],
                        backgroundColor: [
                            '#49BEAA',
                        ]
                    },
                ]
            };

            var myBarChart = new Chart(ctx, {
                scaleStartValue: 0,
                type: 'bar',
                data: data,

            });
        });
    }

</script>
@endpush
@endsection
