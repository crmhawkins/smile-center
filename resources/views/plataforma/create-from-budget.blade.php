@extends('layouts.app')

@section('title', 'Crear Plataforma')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('plataformas.create-from-budget-component')
</div>
@endsection

