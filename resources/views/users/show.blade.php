@extends('layouts.simple')

@section('main-content')

    <h1 class="text-md-center" style="color: white">Utilizadores</h1>

    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    Dados Gerais
                </div>
                <card-body>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Departments</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                @foreach($user->departments as $department)
                                    <p>{{ $department->name }}</p>
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </card-body>
            </div>
        </div>
    </div>

@endsection
