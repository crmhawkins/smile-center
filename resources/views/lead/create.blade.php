@extends('layouts.app')

@section('title', 'Crear Paciente')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('leads.create-component')
</div>
@endsection

