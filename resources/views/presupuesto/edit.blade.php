@extends('layouts.app')

@section('content-principal')

@section('title', 'Presupuestos')


<div>
    @livewire('presupuestos.edit-component', ['identificador'=>$id])
</div>

@endsection

