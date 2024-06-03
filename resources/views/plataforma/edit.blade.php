@extends('layouts.app')

@section('title', 'Editar Plataforma')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('plataformas.edit-component', ['identificador'=>$id])
</div>
@endsection


