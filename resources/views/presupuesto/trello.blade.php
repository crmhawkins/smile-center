@extends('layouts.app')

@section('title', 'Ver Presupuestos')

@section('head')
<link rel="stylesheet" href="/sass/modal.scss">
<link rel="stylesheet" href="/sass/scrumboard.scss">
@endsection

@section('content-principal')
<div>
    @livewire('presupuestos.trello-component')
</div>
@endsection
