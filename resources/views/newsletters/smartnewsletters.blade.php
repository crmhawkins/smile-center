@extends('layouts.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin.css') }}">
@endpush

@section('content-principal')

<div id="content" class="container-fluid">
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de usuario</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('marketing.newsletters.index') }}">Todas las newsletters</a>
            </li>
            <li class="breadcrumb-item active">Añadir</li>
        </ol>
        <div class="row">
            <div class="col">
                <h3>
                    Enviar nueva Smart Newsletter
                </h3>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('marketing.runsmartnewsletter') }}" class="row" enctype="multipart/form-data" data-callback="formCallback">
        <div class="col-lg-10 col-md-10">
            <div class="card" style="padding-bottom: 400px">
                <div class="card-body">
                    <div class="row">

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
                            <label>Newsletter (Solo apareceran las que tienes en favoritos.)</label>
                            <div class="input-group">
                                <select name="newsletter" id="newsletter" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                    @foreach($favs as $fav)
                                        <option value="{{$fav->id}}">{{$fav->first_title_newsletter}} - {{$fav->second_title_newsletter}}</option>
                                    @endforeach
                                </select>
                            </div>
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
                        Enviar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

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

</script>
@endpush
