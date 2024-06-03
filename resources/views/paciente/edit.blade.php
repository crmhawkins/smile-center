@extends('layouts.app')

@section('title', 'Editar Paciente')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('pacientes.edit-component', ['identificador'=>$id])
</div>
@endsection


