<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">NEWSLETTERS</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Newsletters</a></li>
                    <li class="breadcrumb-item active">Crear Newsletters</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->
    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ csrf_token() }}">
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
                            <div class="form-group col-md-12 pacient-container" wire:ignore>
                                <label for="address">Pacientes</label>
                                <div class="col-sm-12">
                                    <select data-pharaonic="select2"
                                            data-component-id="{{ $this->id }}"
                                            class="form-control"
                                            wire:model="pacientes_array_id"
                                            data-placeholder="Buscar..."
                                            data-clear
                                            multiple>
                                            <option value="all">Todos</option>
                                        @foreach($pacientes as $paciente)
                                            <option value="{{$paciente->id}}">{{$paciente->nombre}} {{$paciente->apellido}} - {{$paciente->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12 lead-container" wire:ignore>
                                <label for="address">Leads</label>
                                <div class="col-sm-12">
                                    <select data-pharaonic="select2"
                                            data-component-id="{{ $this->id }}"
                                            class="form-control"
                                            wire:model="pacientes_array_id"
                                            data-placeholder="Buscar..."
                                            data-clear
                                            multiple>
                                        <option value="all">Todos</option>
                                        @foreach($leads as $lead)
                                            <option value="{{$lead->id}}">{{$lead->nombre}} {{$lead->apellido}} - {{$lead->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="Form-group row col-md-12">
                                <div class="col-md-6">
                                    <label for="date">Fecha de envío</label>
                                    <div class="col-sm-12">
                                        <input id='date' type="date" wire:model.lazy="" name="date" class="form-control datetimepicker-input"  required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="time_start">Hora de envío</label>
                                    <div class="col-sm-12">
                                        <input type="time" id="time_start" class="form-control timepicker" name="hour">
                                    </div>
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
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>Acciones</h5>
                    <div class="row">
                        <div class="col-12">
                    <button type="submit" class="btn btn-success btn-block" >
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<!-- JAVASCRIPT -->
<script>
    $(document).ready(function() {
        $(".pacient-container").hide();
        $(".lead-container").hide();

        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="client"){
                $(".lead-container select").val(null).trigger('change');
                $(".pacient-container").show();
                $(".lead-container").hide();
            }
            if($(this).attr("value")=="lead"){
                $(".pacient-container select").val(null).trigger('change');
                $(".pacient-container").hide();
                $(".lead-container").show();
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
