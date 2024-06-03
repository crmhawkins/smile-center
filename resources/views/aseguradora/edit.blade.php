@extends('layouts.app')

@section('title', 'Editar Aseguradoras')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('aseguradoras.edit-component', ['identificador'=>$id])
</div>
@endsection


