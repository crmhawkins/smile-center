@extends('layouts.app')

@section('title', 'Ver Empresas')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('empresas.index-component')
</div>
@endsection
