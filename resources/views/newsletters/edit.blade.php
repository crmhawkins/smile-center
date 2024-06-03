@extends('layouts.app')

@section('title', 'Editar Newsletter')

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
                    <li class="breadcrumb-item active">Editar Newsletters</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <form method="POST" action="{{ route('marketing.newsletters.update', $newsletter->id) }}" class="row" enctype="multipart/form-data" data-callback="formCallback">
        <div class="col-lg-10 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label for="address">Clientes</label>
                            <div class="input-group">
                                <select class="js-select2 form-control js-select2-enabled select2-hidden-accessible select-client" id="select2-multiple-client" name="clients[]" data-placeholder="Buscar..." style="width: 100%" multiple="multiple" data-select2-id="example-select2-multiple" tabindex="-1" aria-hidden="true" required>
                                    @if($newsletter->pacientes_array_id == "all")
                                        <option value="all" selected>Todos</option>
                                    @else
                                        @foreach($clients as $client)
                                            @foreach($newsletter->pacientes_array_id as $client_id)
                                                <option value="{{ $client->id }}" @if ($client->id == $client_id) {{ 'selected'}} @endif >{{$client->nombre}} {{$client->apellido}} - {{$client->email}}</option>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Categoria</label>
                            <div class="input-group">
                                <select name="category" id="category" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" readonly>
                                    <option value="{{$newsletter->category}}"> {{$newsletter->name_category->name}} </option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                           <label for="date">Fecha de envio</label>
                            <div class='input-group date datepicker' style="border:none;padding:0px;"  data-target-input="nearest" >
                                <input  id='date' type="text" name="date" class="form-control datetimepicker-input" data-target="#to_date" style="width: 0px;" value="{{ \Carbon\Carbon::parse($newsletter->date_sent)->format('d/m/Y') }}" required/>
                                <span class="input-group-text" data-target="#date" data-toggle="datetimepicker" >
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                           <label for="date">Hora de envio</label>
                            <div class='input-group time timepicker' style="border:none;padding:0px;"  data-target-input="nearest" >
                                <input type="text" id="time_start" class="form-control timepicker" name="hour" value="{{ \Carbon\Carbon::parse($newsletter->date_sent)->format('H:i') }}">
                                <span class="input-group-text" data-toggle="timepicker" >
                                    <span class="fa fa-clock"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <h2 style="text-align: center;">Maquetación</h2>
                            <hr>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Titulo Newsletter</label>
                            <input type="text" name="first_title_newsletter" class="form-control" required value="{{$newsletter->first_title_newsletter}}">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <div class="custom-file">
                                <input type="file" name="banner" class="custom-file-input" id="chooseFile" data-id="banner">
                                <label class="custom-file-label" for="chooseFile">Seleccionar imagen</label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload-banner" src="{{ asset('images/'.$newsletter->images_promo[0]) }}" alt="preview image" style="max-height: 250px;">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Enlace a la imagen</label>
                            <input type="text" name="urls[]" class="form-control" value="{{$newsletter->urls[0]}}" required>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Texto descriptivo de la imagen anterior (Por si la imagen no se descarga en el gestor de emails)</label>
                            <input type="text" name="banner_description" class="form-control" required value="{{$newsletter->banner_description}}">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Titulo 2</label>
                            <input type="text" name="second_title_newsletter" class="form-control" placeholder="Quizás también te interese.." required value="{{$newsletter->second_title_newsletter}}">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <div class="custom-file">
                                <input type="file" name="promo1" class="custom-file-input" id="chooseFile" data-id="1">
                                <label class="custom-file-label" for="chooseFile">Seleccionar promo 1</label>

                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload-1" src="{{ asset('images/'.$newsletter->images_promo[1]) }}" alt="preview image" style="max-height: 250px;">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Enlace a la imagen</label>
                            <input type="text" name="urls[]" class="form-control" value="{{$newsletter->urls[1]}}" required>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <div class="custom-file">
                                <input type="file" name="promo2" class="custom-file-input" id="chooseFile" data-id="2">
                                <label class="custom-file-label" for="chooseFile">Seleccionar promo 2</label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload-2" src="{{ asset('images/'.$newsletter->images_promo[2]) }}" alt="preview image" style="max-height: 250px;">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Enlace a la imagen</label>
                            <input type="text" name="urls[]" class="form-control" value="{{$newsletter->urls[2]}}" required>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <div class="custom-file">
                                <input type="file" name="promo3" class="custom-file-input" id="chooseFile" data-id="3">
                                <label class="custom-file-label" for="chooseFile">Seleccionar promo 3</label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload-3" src="{{ asset('images/'.$newsletter->images_promo[3]) }}" alt="preview image" style="max-height: 250px;">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Enlace a la imagen</label>
                            <input type="text" name="urls[]" class="form-control" value="{{$newsletter->urls[3]}}" required>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <div class="custom-file">
                                <input type="file" name="promo4" class="custom-file-input" id="chooseFile" data-id="4">
                                <label class="custom-file-label" for="chooseFile">Seleccionar promo 4</label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload-4" src="{{ asset('images/'.$newsletter->images_promo[4]) }}" alt="preview image" style="max-height: 250px;">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Enlace a la imagen</label>
                            <input type="text" name="urls[]" class="form-control" value="{{$newsletter->urls[4]}}" required>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <div class="custom-file">
                                <input type="file" name="promo5" class="custom-file-input" id="chooseFile" data-id="5">
                                <label class="custom-file-label" for="chooseFile">Seleccionar promo 5</label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload-5" src="{{ asset('images/'.$newsletter->images_promo[5]) }}" alt="preview image" style="max-height: 250px;">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Enlace a la imagen</label>
                            <input type="text" name="urls[]" class="form-control" value="{{$newsletter->urls[5]}}" required>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <div class="custom-file">
                                <input type="file" name="promo6" class="custom-file-input" id="chooseFile" data-id="6">
                                <label class="custom-file-label" for="chooseFile">Seleccionar promo 6</label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload-6" src="{{ asset('images/'.$newsletter->images_promo[6]) }}" alt="preview image" style="max-height: 250px;">
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Enlace a la imagen</label>
                            <input type="text" name="urls[]" class="form-control" value="{{$newsletter->urls[6]}}" required>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar_content" class="col-lg-2 col-md-2">
            <div class="card" id="actions-panel">
                <div class="card-header">
                    Acciones
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-success btn-block" >
                        Guardar
                    </button>
                    <button type="button" id="addFavoriteNewsletter" class="btn btn-info btn-block">
                        Añadir a Favoritos
                    </button>
                    <button type="button" id="sendNewsletter" class="btn btn-info btn-block">
                        Volver a enviar
                    </button>
                    <button type="button" id="deleteEntry" class="btn btn-outline-danger btn-block">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<form id ="addFavourites" method="POST"  action="{{ route('marketing.newsletters.favourites.add', $newsletter->id) }}" class="row" enctype="multipart/form-data"  data-callback="formCallbackAddFavouritesForm"></form>
<form id ="send" method="POST"  action="{{ route('marketing.newsletters.send', $newsletter->id) }}" class="row" enctype="multipart/form-data"  data-callback="formCallbackSendForm"></form>

@endsection


@push('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<!-- JAVASCRIPT -->
<script type="text/javascript">
    function formCallback(data) {
        CommonFunctions.notificationSuccessStayOrBack(data.message, data.entryUrl, "{{route('marketing.newsletters.index')}}");
    }


    $(document).ready(function() {

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

    function formCallbackAddFavouritesForm(data) {
        CommonFunctions.notificationSuccessStayOrBack(data.message, data.entryUrl, "{{route('marketing.newsletters.edit', $newsletter->id)}}");
    }
    $('#addFavoriteNewsletter').click(function() {

        swal({
            type: 'info',
            title: 'Quieres añadir está newsletter a favoritos?',
            text: 'Podrás encontrar está newsletter a tu lista de favoritas con la que podrás enviar Smarts newsletters',
            allowEscapeKey: false,
            allowOutsideClick: false,
            allowEnterKey: false,
            showCancelButton: true,
            confirmButtonColor: '#10ba46',
            confirmButtonText: 'Añadir',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $('.swal2-buttonswrapper > button:not(:first)').remove();
                    $('#addFavourites').submit();
                });
            }
        });

    });

     // Cancelar presupuesto
    function formCallbackSendForm(data) {
        CommonFunctions.notificationSuccessStayOrBack(data.message, data.entryUrl, "{{route('marketing.newsletters.favourites.add', $newsletter->id)}}");
    }
    $('#sendNewsletter').click(function() {
        let fecha = $('#date').val();
        let hora = $('#time_start').val();
        swal({
            type: 'info',
            title: 'Enviar Newsletter',
            text: 'Se enviará el '+fecha+' a las '+hora+', ¿estás conforme?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            allowEnterKey: false,
            showCancelButton: true,
            confirmButtonColor: '#10ba46',
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $('.swal2-buttonswrapper > button:not(:first)').remove();
                    $('#send').submit();
                });
            }
        });

    });

    function formCallback(data) {
        CommonFunctions.notificationSuccessStayOrBack(data.message, data.entryUrl, "{{route('marketing.newsletters.index')}}");
    }
    $('#deleteEntry').click(function() {
        CommonFunctions.notificationConfirmDelete(
            "Va a eliminar este newsletter. Esta acción no puede deshacerse",
            'Borrar',
            "{{ route('marketing.newsletters.destroy', $newsletter->id) }}",
            function(data) {
                CommonFunctions.notificationSuccessRedirect(data.message, "{{route('marketing.newsletters.index')}}");
            }
        );
    });

</script>
@endpush
