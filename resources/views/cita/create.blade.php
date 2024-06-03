@extends('layouts.app')

@section('title', 'Crear citas')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
@if (isset($id))
    <div>
        @livewire('citas.create-component', ['presupuesto_id'=>$id])
    </div>
@else
    <div>
        @livewire('citas.create-component')
    </div>
@endif
@endsection
