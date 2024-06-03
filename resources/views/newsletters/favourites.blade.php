@extends('layouts.app')

@section('content-principal')

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
                    <a href="{{ route('marketing.newsletters.create') }}" class="btn btn-outline-light">
                        <i class="icon-plus icons icon_l"></i> Añadir campaña de marketing
                    </a>
                </h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="block block-rounded">
                <div class="block-header">
                  <h3 class="block-title">NEWSLETTERS FAVORITAS</h3>
                </div>
                <div class="block-content block-content-full">
                    @if($favs)
                     <table class="table data_table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Campaña</th>
                                <th>Fecha de envio</th>
                                <th>Titulo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($favs as $favourite)
                                 <tr data-href="{{route('marketing.newsletters.edit', $favourite->id)}}">
                                    <td>{{ $favourite->id }}</td>

                                    <td>
                                        @if($favourite->clients_id)
                                            @php
                                                $num_items = count($favourite->clients_id);
                                                $i = 0;
                                                foreach($favourite->clients_id as $client){
                                                    if(++$i === $num_items){
                                                        echo($client->name);
                                                    }
                                                    else{
                                                         echo($client->name . ", ");
                                                    }
                                                }
                                            @endphp
                                        @endif
                                    </td>
                                    <td>{{ $favourite->getCategory->name }}</td>
                                    <td>{{ $favourite->date_sent }}</td>
                                    <td>{{ $favourite->first_title_newsletter }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- JS -->
<script type="text/javascript">

</script>
@endpush
