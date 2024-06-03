@extends('layouts.app')

@section('title', 'Crear Newsletter')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">NEWSLETTERS</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('marketing.newsletters.index')}}">Newsletters</a></li>
                    <li class="breadcrumb-item active">Crear Newsletters</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <form method="POST" action="{{ route('marketing.newsletters.store') }}" class="row" enctype="multipart/form-data" data-callback="formCallback">
        @csrf
    <div class="row">
        <div class="col-md-10">
            <div class="card m-b-30">
                <div class="card-body">
                        <div class="form-row mb-4 justify-content-center">
                            <div class="form-group col-md-12">
                                <h5 style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">Datos de la Newsletter</h5>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Selecciona el tipo:</label>
                                <div class="form-radio">
                                    <input class="form-radio-input" type="radio" name="type" id="flexRadioDefault1" value="client">
                                    <label class="form-radio-label" for="flexRadioDefault1">Paciente</label>
                                </div>
                                <div class="form-radio">
                                    <input class="form-radio-input" type="radio" name="type" id="flexRadioDefault2" value="lead">
                                    <label class="form-radio-label" for="flexRadioDefault2">Leads</label>
                                </div>
                            </div>
{{--
                            <div class="form-group col-md-12 activity-container">
                                <label>Escribe aquí la actividad (Arquitectos, inmobiliaria, etc.) a la que deseas enviar la newsletter. Solo podrás escribir una.</label>
                                <input type="text" name="activity" class="form-control">
                            </div> --}}

                            <div class="form-group col-md-12 client-container">
                                <label for="address">Pacientes</label>
                                <select class="js-select2 form-control select-client d-block" id="select2-multiple-client" name="clients[]" data-placeholder="Buscar..." multiple="multiple">
                                    <option value="all">Todos</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->nombre}} {{$client->apellido}} - {{$client->email}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="date">Fecha de envío</label>
                                <div class='input-group date datepicker' data-target-input="nearest">
                                    <input id='date' type="date" name="date" class="form-control datetimepicker-input" data-target="#date" required/>
                                    <span class="input-group-text" data-target="#date" data-toggle="datetimepicker">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="time_start">Hora de envío</label>
                                <div class='input-group time timepicker' data-target-input="nearest">
                                    <input type="time" id="time_start" class="form-control timepicker" name="hour">
                                    <span class="input-group-text" data-toggle="timepicker">
                                        <span class="fa fa-clock"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <h5 style="text-align: center;">Maquetación</h5>
                                <hr>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Titulo Newsletter</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="form-group col-md-12">
                                <div class="custom-file">
                                    <input type="file" name="banner" class="custom-file-input" id="chooseFile" data-id="banner" required>
                                    <label class="custom-file-label" for="chooseFile">Seleccionar imagen</label>
                                </div>
                                <img id="preview-image-before-upload-banner" src="https://dummyimage.com/600x400/000/fff" alt="preview image" style="max-height: 250px;">
                            </div>

                            <div class="form-group col-md-12">
                                <label>Enlace a la imagen</label>
                                <input type="text" name="urls[]" class="form-control" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Texto descriptivo de la imagen anterior (Por si la imagen no se descarga en el gestor de emails)</label>
                                <input type="text" name="img_description" class="form-control" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Titulo 2</label>
                                <input type="text" name="title_second" class="form-control" placeholder="Quizás también te interese.." required>
                            </div>

                            @for($i = 1; $i <= 6; $i++)
                                <div class="form-group col-md-12">
                                    <div class="custom-file">
                                        <input type="file" name="promo{{$i}}" class="custom-file-input" id="chooseFile" data-id="{{$i}}" {{ $i <= 3 ? 'required' : '' }}>
                                        <label class="custom-file-label" for="chooseFile">Seleccionar promo {{$i}}</label>
                                    </div>
                                    <img id="preview-image-before-upload-{{$i}}" src="https://dummyimage.com/250x160/000/fff" alt="preview image" style="max-height: 250px;">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Enlace a la imagen</label>
                                    <input type="text" name="urls[]" class="form-control" required>
                                </div>
                            @endfor

                        </div>
                    </div>
                </div>
            </div>
            <div id="sidebar_content" class="col-md-2">
                <div class="card" id="actions-panel">
                    <div class="card-header">
                        Acciones
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-success btn-block" >
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<!-- JAVASCRIPT -->
<script type="text/javascript">
    function formCallback(data) {
        CommonFunctions.notificationSuccessStayOrBack(data.message, data.entryUrl, "{{route('marketing.newsletters.index')}}");
    }

    $(document).ready(function() {
        $(".client-container").hide();
        $(".activity-container").hide();

        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="client"){
                $(".client-container").show();
                $(".activity-container").hide();
            }
            if($(this).attr("value")=="lead"){
                $(".client-container").hide();
                $(".activity-container").show();
            }
        });

        $('.custom-file-input').change(function(){
            let reader = new FileReader();
            let id = $(this).attr('data-id');

            reader.onload = (e) => {
              $('#preview-image-before-upload-'+id).attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
       });

        $('.select-client').select2();

        $('#date').datetimepicker({
            format: 'DD/MM/YYYY',
            date: new Date(),
        });

        $('.timepicker').timepicker({
            interval: 5,
            timeFormat: 'H:mm',
            minTime: '9',
            maxTime: '7:00pm',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

    });

</script>
@endsection
@endsection
