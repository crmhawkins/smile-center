
@extends('layouts.app')

@section('title', 'Ver Plataforma')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('plataformas.index-component')
</div>
@endsection
