@section('head')
    @vite(['resources/sass/productos.scss'])
@endsection

<div class="container mx-auto">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR PACK DE SERVICIO</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pack de Servicios</a></li>
                    <li class="breadcrumb-item active">Crear pack de servicio</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                        <div class="container text-center">
                            <div class="mb-3 row d-flex align-items-center">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre </label>
                                <div class="col-sm-5">
                                    <input type="text" wire:model="nombre" class="form-control" name="nombre" id="nombre"
                                        placeholder="Pack">
                                    @error('nombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row d-flex align-items-center">
                                <label for="servicio" class="col-sm-2 col-form-label">Servicio </label>
                                <select class="col-sm-2 input-group-text" name="servicio" id="servicio" wire:model="servicio">
                                    <option class="dropdown-item" value="">Servicio</option>
                                    @foreach ($servicios as $i => $servicio)
                                        <option class="dropdown-item"  value="{{ $servicio->id }}">
                                            {{ $servicio->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" wire:click="addServ" class="col-sm-1 btn btn-primary">Añadir</button>
                            </div>
                
                            <div class="mb-3 row d-flex align-items-center">
                                @foreach ($serviciosPack as $key => $servicio)
                                    <div class="mb-3 row d-flex align-items-center">
                                        <h4 for="servicio.{{ $key }}" class="col-sm-1 col-form-label">Servicio</h4>
                                        <h4 for="servicio.{{ $key }}" class="col-sm-3 col-form-label">{{ $servicio["nombre"] }}
                                        </h4>
                                        <button type="button" wire:click="removeServ({{ $key }})" class="col-sm-1 btn btn-outline-danger">Eliminar</button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-3 row d-flex align-items-center">
                                <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Guardar</button>
                            </div>
                                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    



</div>
