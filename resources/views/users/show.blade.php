@extends('layouts.simple')

@section('main-content')

    <h1>Ficha de funcionario</h1>

    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    Dados Gerais
                </div>
                <card-body>
                    ola {{ $user->name }}
                </card-body>
            </div>
        </div>
    </div>

@endsection
