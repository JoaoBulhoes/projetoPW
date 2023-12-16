@extends('layouts.autenticado')

@section('main-content')
<div class="container">
    <div class="row mt-5">
        <div class="col">
            @can('create', \App\Models\User::class)
            <p class="text-right">
                <a href="{{ route('metadataTypes.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus fa-fw mr-2"></i>Adicionar Tipo de metadata
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
                    @foreach($metadataTypes as $metadataType)
                            <tr>
                                <td>{{ $metadataType->name }}</td>
                                <td class="text-end">
                                    @can('delete', $metadataType)
                                        <form action="{{ route('metadataTypes.destroy', ['metadataType' => $metadataType]) }}" method="POST" class="d-inline">
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

                {{ $metadataTypes->links() }}
        </div>
    </div>
</div>
@endsection
