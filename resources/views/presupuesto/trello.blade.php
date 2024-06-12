@extends('layouts.app')

@section('title', 'Ver Presupuestos')

@section('head')
    @vite(['resources/sass/modal.scss'])
    @vite(['resources/sass/scrumboard.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('presupuestos.trello-component')
</div>
@endsection
