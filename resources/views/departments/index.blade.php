@extends('layouts.autenticado')

@section('main-content')
<div class="container">
    <div class="row mt-5">
        <div class="col">
            @can('create', \App\Models\User::class)
            <p class="text-right">
                <a href="{{ route('departments.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus fa-fw mr-2"></i>Adicionar Departamento
                </a>
            </p>
            @endcan

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-end">Acções</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($departments as $department)
                            <tr>
                                <td>{{ $department->name }}</td>
                                <td class="text-end">
                                    @can('delete', $department)
                                        <form action="{{ route('departments.destroy', ['department' => $department]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Apagar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>

                {{ $departments->links() }}
        </div>
    </div>
</div>
@endsection
