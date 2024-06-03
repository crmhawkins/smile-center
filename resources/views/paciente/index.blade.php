
@extends('layouts.app')

@section('title', 'Ver Pacientes')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('pacientes.index-component')
</div>
@endsection
