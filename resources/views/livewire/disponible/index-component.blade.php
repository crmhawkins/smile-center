<script src="//unpkg.com/alpinejs" defer></script>
    <?php

    use Carbon\Carbon;
    ?>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">SERVICIOS DISPONIBLES</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Servicios Disponibles</a></li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <div class="row">
        <div class="col-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Listado de todos los servicios</h4>
                    <p class="sub-title">Listado completo de todos nuestros eventos</p>
                    @if (count($servicios) > 0)
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Servicio</th>
                                    <th scope="col">Stock total</th>
                                    <th scope="col">Disponibles</th>
                                    <th scope="col">Articulos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($servicios as $servicio)
                                    <tr>
                                        <td>{{ $servicio->nombre }}</td>
                                        <td>
                                            @php
                                                $sumatorio = 0;
                                                foreach ($articulos as $articulo) {
                                                    if ($articulo->id_categoria == $servicio->id) {
                                                        $sumatorio += 1;
                                                    }
                                                }
                                                echo $sumatorio; // Mostramos el sumatorio
                                            @endphp
                                        </td>
                                        <td>{{ $servicio->nombre }}</td>
                                        <td class="details-control" data-id="{{ $servicio->id }}" style="cursor: pointer;">
                                            <span>Ver artículos</span>
                                            <div class="articulos" style="display: none;">
                                                <ul>
                                                    @foreach ($articulos as $articulo)
                                                        @if ($articulo->id_categoria == $servicio->id)
                                                            <li>{{ $articulo->name }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card m-b-30 position-fixed">
                <div class="card-body">
                    <h5>Elige un día para mostrar</h5>
                    <div class="row">
                        <div class="col-12">
                            <input type="date" class="form-control" wire:model="dia" wire:change="cambiodia">
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
    document.querySelectorAll('.details-control').forEach(function(element) {
        element.addEventListener('click', function() {
            var articulos = this.querySelector('.articulos');
            articulos.style.display = articulos.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>
