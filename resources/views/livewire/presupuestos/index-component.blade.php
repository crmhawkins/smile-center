<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">PRESUPUESTOS</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Presupuestos</a></li>
                    <li class="breadcrumb-item active">Todos los Presupuestos</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Listado de todos los presupuestos</h4>
                    <p class="sub-title../plugins">Listado completo de todos nuestros presupuestos, para editar o ver la informacion completa pulse el boton de Editar en la columna acciones.
                    </p>
                    @if (count($presupuestos) > 0)
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">Número</th>
                                <th scope="col">Fecha emisión</th>
                                <th scope="col">Paciente</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Recorre los presupuestos --}}
                            @foreach ($presupuestos as $presup)
                            <tr>
                                <td>{{ $presup->id }}</td>
                                <td>{{ $presup->fechaEmision }}</td>
                                <td>{{ $this->getClienteNombre($presup->paciente_id) }}</td>
                                <td>
                                    @switch($presup->estado_id)
                                        @case(1)
                                        <span class="badge badge-warning">{{$this->getEstado($presup->estado_id)}}</span>
                                            @break
                                        @case(2)
                                        <span class="badge badge-success">{{$this->getEstado($presup->estado_id)}}</span>
                                            @break
                                        @case(3)
                                        <span class="badge badge-danger">{{$this->getEstado($presup->estado_id)}}</span>
                                            @break
                                        @case(4)
                                        <span class="badge badge-primary">{{$this->getEstado($presup->estado_id)}}</span>
                                            @break
                                        @case(5)
                                        <span class="badge badge-info">{{$this->getEstado($presup->estado_id)}}</span>
                                            @break
                                        @default
                                        <span class="badge badge-info">{{$this->getEstado($presup->estado_id)}}</span>
                                    @endswitch
                                </td>
                                <td>{{ number_format(intval($this->getTotal($presup->id)), 2, ',', '.') }}</td>
                                <td>
                                    <a href="presupuestos-edit/{{ $presup->id }}" class="btn btn-primary">Ver/Editar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <h6 class="text-center">No se encuentran presupuestos disponibles</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>




</div>


@section('scripts')
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
@endsection
