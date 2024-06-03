@extends('layouts.app')

@section('title', 'Editar Citas')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('citas.edit-component', ['identificador'=>$id])
</div>
@endsection
