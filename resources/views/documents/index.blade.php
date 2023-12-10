@extends('layouts.autenticado')

@section('main-content')
    <div class="container">
        <div class="row mt-5">
            <div class="col">
{{--                @can('create', \App\Models\Document::class)--}}
                    <p class="text-right">
                        <a href="{{ route('documents.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus fa-fw mr-2"></i>Adicionar Documento
                        </a>
                    </p>
{{--                @endcan--}}

                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>path</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($documents as $document)
                        <tr>
                            <td>{{ $document->id }}</td>
                            <td>{{ $document->path }}</td>
                            <td class="text-end">
                                @can('view', $document)
                                    <a href="{{ route('documents.show', ['document' => $document]) }}"
                                       class="btn btn-primary btn-sm">Ver</a>
                                @endcan

                                @can('download', $document)
                                    <a href="{{ route('documents.edit', ['document' => $document]) }}"
                                       class="btn btn-primary btn-sm">Download</a>
                                @endcan

                                @can('update', $document)
                                    <a href="{{ route('documents.edit', ['document' => $document]) }}"
                                       class="btn btn-warning btn-sm">Modificar</a>
                                @endcan

                                @can('delete', $document)
                                    <form action="{{ route('documents.destroy', ['document' => $document]) }}"
                                          method="POST" class="d-inline">
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

                {{ $documents->links() }}
            </div>
        </div>
    </div>
@endsection
