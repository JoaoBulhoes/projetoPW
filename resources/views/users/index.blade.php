@extends('layouts.autenticado')

@section('main-content')
<div class="container">
    <div class="row mt-5">
        <div class="col">
            @can('create', \App\Models\User::class)
            <p class="text-right">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus fa-fw mr-2"></i>Adicionar Utilizador
                </a>
            </p>
            @endcan

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Código</th>
                        <th class="text-end">Acções</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        @if($user->id !== \Illuminate\Support\Facades\Auth::id())
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->code }}</td>
                                <td class="text-end">
                                    <a href="{{ route('users.show', ['user' => $user]) }}" class="btn btn-primary btn-sm">Ver</a>

                                    @can('update', $user)
                                        <a href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-warning btn-sm">Modificar</a>
                                    @endcan

                                    @can('delete', $user)
                                        <form action="{{ route('users.destroy', ['user' => $user]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Apagar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

                {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
