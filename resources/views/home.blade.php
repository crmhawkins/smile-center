@extends('layouts.app')

@section('title', 'Dashboard')
@section('content-principal')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        {{-- {{var_dump($alertas)}} --}}

                    <h2>Bienvenido, {{ $user->name }}</h2>
                    {{ __('¡Estás logeado!') }}
                </div>
            </div>
        </div>
    </div>

@endsection
