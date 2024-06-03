
@extends('layouts.app')

@section('title', 'Ver Citas')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('citas.index-component')
</div>
@endsection
