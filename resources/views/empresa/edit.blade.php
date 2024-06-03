@extends('layouts.app')

@section('title', 'Editar Empresa')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('empresas.edit-component', ['identificador'=>$id])
</div>
@endsection
