@extends('layouts.app')

@section('title', 'Crear Aseguradoras')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('aseguradoras.create-from-budget-component')
</div>
@endsection

