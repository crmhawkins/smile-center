@extends('layouts.app')

@section('title', 'Ver Presupuestos')

@section('head')

@endsection

@section('content-principal')
<div>
    @livewire('presupuestos.trello-component')
</div>
@endsection
