<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR DEPARTAMENTO</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Departamentos</a></li>
                    <li class="breadcrumb-item active">Crear departamento</li>
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
                        <input type="hidden" name="id" value="{{ csrf_token() }}">
                                   
                        <!-- Nombre -->
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="name" class="form-control" name="name" id="name"
                                aria-label="Nombre" placeholder="Nombre">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>


                                    <style>
                                        .nombre {
                                            color: red;
                                        }
                                    </style>
                                @enderror
                            </div>
                        </div>
                
                        <div class="form-group row mt-3">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Guardar</button>
                        </div> 
                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
