@extends('layouts.app')

@section('title', 'Ver Presupuestos')

@section('head')
    @asset(['/build/assets/modal.792ba9aa.css'])
    @asset(['/build/assets/scrumboard.1a06ab04.css'])
@endsection

@section('content-principal')
<div>
    @livewire('presupuestos.trello-component')
</div>
@endsection
