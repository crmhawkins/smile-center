@extends('layouts.app')

@section('content')

@section('title', 'Contrato')


<div>
    @livewire('contratos.edit-component', ['identificador'=>$id])
</div>

@endsection

