@extends('layouts.app')

@section('content')

@section('title', 'Empresas')


<div>
    @livewire('monitores.edit-component', ['identificador'=>$id])
</div>

@endsection

