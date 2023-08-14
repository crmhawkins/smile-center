<div class="container mx-auto">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR CATEGORIA DE SERVICIO</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Categoria de Servicios</a></li>
                    <li class="breadcrumb-item active">Crear categoria de servicio</li>
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
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre de la categoría</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" wire:model="nombre" nombre="nombre" id="nombre"
                                    placeholder="Nombre de la categoría...">
                                @error('nombre')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                
                
                        <div class="mb-3 row d-flex align-items-center">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Guardar</button>
                        </div>
                
                
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</div>
