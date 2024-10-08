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
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Filtrar Presupuestos</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fechaInicio">Fecha Inicio</label>
                            <input type="date" wire:model="fechaInicio" id="fechaInicio" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaFin">Fecha Fin</label>
                            <input type="date" wire:model="fechaFin" id="fechaFin" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="cancel-row">
        <div class="col-lg-12 layout-spacing">
            <div class="m-b-30">
                <div class="carb-body p-4">
                    <h4 class="mt-0 header-title">Flujo de los presupuestos</h4>
                    <p class="sub-title">Listado completo de todos nuestros presupuestos</p>
                    <div class="task-list-section">
                        @foreach ($estados as $estado)
                            <div class="task-list-container mb-5" data-connect="sorting" data-section="s-{{ $estado->id }}">
                                <div class="connect-sorting">
                                    <div class="task-container-header">
                                        <h6 class="s-heading" data-listTitle="{{ $estado->estado }}">{{ $estado->estado }}</h6>
                                    </div>
                                    <div class="connect-sorting-content" id="estado-{{ $estado->id }}" data-sortable="true">
                                        @foreach ($presupuestosPorEstado['presupuestos']->get($estado->id, []) as $presupuesto)
                                            <div class="card img-task fina" id="presupuesto-{{ $presupuesto->id }}" data-draggable="true">
                                                <div class="card-body fina cursor-pointer" data-presupuesto-id="{{ $presupuesto->id }}">
                                                    <div class="task">
                                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                            <h5 class="card-title" data-taskTitle="titulo">{{ $this->getClienteNombre($presupuesto->paciente_id) }}</h5>
                                                            <p class="card-text"><strong>Total:</strong> {{ number_format(intval($this->getTotal($presupuesto)), 2, ',', '.') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="sumatorio d-flex flex-row justify-content-around align-items-center">
                                        <label for="total">Total:</label>
                                        <h4>{{  number_format(($presupuestosPorEstado['totales'][$estado->id] ?? 0) , 2, ',', '.')}} €</h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="{{asset('plugins/global/vendors.min.js')}}"></script>
<script src="{{asset('plugins/global/jquery-ui.min.js')}}"></script>
<script src="{{asset('plugins/global/scrumboard.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.card-body[data-presupuesto-id]');
        let clickStartTime;

        cards.forEach(card => {
            card.addEventListener('mousedown', function () {
                clickStartTime = new Date().getTime();
            });

            card.addEventListener('mouseup', function (event) {
                const clickDuration = new Date().getTime() - clickStartTime;
                if (clickDuration < 200) { // Considered as a short click
                    const presupuestoId = this.getAttribute('data-presupuesto-id');
                    window.location.href = `/admin/presupuestos-edit/${presupuestoId}`;
                }
            });
        });
    });
</script>
<style>
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endsection
