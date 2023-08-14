@extends('layouts.app')

@section('content')

@section('title', 'Editar Servicio')


<div>
    @livewire('servicios.edit-component', ['identificador'=>$id])
</div>

@endsection

