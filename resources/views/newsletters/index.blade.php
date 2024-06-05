@extends('layouts.app')

@section('content-principal')

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
                    <li class="breadcrumb-item active">Todos las Newsletters</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->
    <div class="row">
        <div class="col-md-12">
            <div class="block block-rounded">
                <div class="block-header d-flex align-items-center justify-content-between ">
                  <h3 class="block-title">NEWSLETTERS</h3>
                  <a href="{{ route('marketing.newsletters.create') }}" class="btn btn-outline-secondary ml-5"><i class="icon-plus icons icon_l"></i> Añadir campaña de marketing</a>
                </div>
                <div class="block-content block-content-full">
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha de envio</th>
                                <th>Titulo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($newsletters)
                                @foreach ($newsletters as $newsletter)
                                <tr data-href="{{route('marketing.newsletters.edit', $newsletter->id)}}">
                                    <td>{{ $newsletter->id }}</td>
                                    <td>
                                        @if($newsletter->clients_id == "all")
                                            Todos
                                        @else
                                            @if($newsletter->clients_id)
                                                @php
                                                    $num_items = count($newsletter->clients_id);
                                                    $i = 0;
                                                    foreach($newsletter->clients_id as $client){
                                                        if($client){
                                                            if(++$i === $num_items){
                                                                echo($client->nombre);
                                                            }
                                                            else{
                                                                echo($client->nombre . ", ");
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $newsletter->date_sent }}</td>
                                    <td>{{ $newsletter->first_title_newsletter }}</td>
                                    <td>
                                        <a href="{{ route('marketing.newsletters.edit', $newsletter->id)}}" class="btn btn-primary">Editar</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')

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

</script>
@endsection
@endsection

