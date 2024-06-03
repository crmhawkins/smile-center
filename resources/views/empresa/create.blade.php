@extends('layouts.app')

@section('title', 'Crear Empresa')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('empresas.create-component')
</div>
@endsection
