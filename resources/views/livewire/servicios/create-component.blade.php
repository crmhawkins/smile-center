<div class="container mx-auto">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR SERVICIO</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Servicios</a></li>
                    <li class="breadcrumb-item active">Crear servicio</li>
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
                
                        <div class="mb-3 row d-flex align-items-center">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre </label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="nombre" class="form-control" name="nombre" id="nombre"
                                    placeholder="Evento">
                                @error('nombre')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                
                        <div class="mb-3 row d-flex align-items-center">
                            <label for="id_categoria" class="col-sm-2 col-form-label">Categoria </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="id_categoria" required id="id_categoria" wire:model="id_categoria">
                                    <option value="">Categorias</option>
                                    @foreach ($servicioCategorias as $categoria)
                                        <option value="{{ $categoria->id }}">
                                            {{ $categoria->nombre }}</option>
                                    @endforeach
                                    <option value="" wire:click.prevetn="crearCategoria">Crear Categoria</option>
                                    @error('id_categoria')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </select>
                            </div>
                        </div>
                
                        <div class="mb-3 row d-flex align-items-center">
                            <label for="id_pack" class="col-sm-2 col-form-label">Pack </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="id_pack" required id="id_pack"
                                    wire:model="id_pack">
                                    <option value="">Pack</option>
                                    @foreach ($servicioPacks as $pack)
                                        <option value="{{ $pack->id }}">{{ $pack->nombre }}
                                        </option>
                                    @endforeach
                                    <option value="" wire:click.prevetn="crearPack">Crear Pack</option>
                                    @error('id_pack')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </select>
                            </div>
                        </div>
                
                
                        <div class="mb-3 row d-flex align-items-center">
                            <label for="precioBase" class="col-sm-2 col-form-label">Precio Base </label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="precioBase" class="form-control" name="precioBase" id="precioBase"
                                    placeholder="0">
                                @error('precioBase')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                
                        <div class="mb-3 row d-flex align-items-center">
                            <label for="minMonitor" class="col-sm-2 col-form-label">Nº minimo de monitores </label>
                            <div class="col-sm-10">
                                <input type="number" wire:model="minMonitor" class="form-control" name="minMonitors"
                                    id="minMonitor" placeholder="1">
                                @error('minEmpleados')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                
                        <div class="mb-3 row d-flex align-items-center">
                            <label for="precioMonitor" class="col-sm-2 col-form-label">Precio por monitor </label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="precioMonitor" class="form-control" name="precioMonitor" id="precioMonitor"
                                    placeholder="20">
                                @error('precioMonitor')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                
                        @if($minMonitor !== null && $precioMonitor !== null && $precioBase !== null)
                
                        <div class="mb-3 row d-flex align-items-center">
                            <label for="precioTotal" class="col-sm-2 col-form-label">Precio total estimado </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="precioTotal" id="precioTotal"
                                    placeholder="1" disabled value="{{ $this->precioTotal() }}">
                            </div>
                        </div>
                        @endif
                
                        <div class="mb-3 row d-flex align-items-center">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Guardar</button>
                        </div>
                
                
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

