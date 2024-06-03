@extends('layouts.app')

@section('content-principal')
<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Logs</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Logs</a></li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row justify-content-md-center">
        <div class="col-md-12">
        <table id="dataTableExpenses" class="table table-hover table-striped table-bordered table-gastos" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><b>Id</b></th>
                        <th><b>Usuario Id</b></th>
                        <th><b>Accion</b></th>
                        <th><b>Descripcion</b></th>
                        <th><b>Fecha</b></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{$log->id}}</td>
                        <td>{{$log->user_id}}</td>
                        <td>{{$log->action}}</td>
                        <td>{{$log->description}}</td>
                        <td>{{$log->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- JS -->

<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/b-3.0.2/r-3.0.2/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/b-3.0.2/r-3.0.2/datatables.min.js"></script>
<script>
$(document).ready(function() {
    new DataTable('#dataTableExpenses');
});
</script>

@endsection
