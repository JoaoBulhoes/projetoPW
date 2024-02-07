<div class="row mt-5">
    <div class="col-6">
        <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="procurar por nome do ficheiro">
    </div>

    <div class="col-4">
        <p class="text-right">
            <a href="{{ route('documents.create') }}" class="btn btn-primary">
                <i class="fa fa-plus fa-fw mr-2"></i>Adicionar Documento
            </a>
        </p>
    </div>

    <br>
    <div class="col">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Path</th>
                <th class="text-end">Ações</th>
            </tr>
            </thead>

            <tbody>
            @foreach($documents as $document)
                {{-- @if($document->id !== \Illuminate\Support\Facades\Auth::id())--}}
                <tr>
                    <td>{{ $document->id }}</td>
                    @php($doc_name = \App\Services\DocumentService::getName($document))
                    <td><p class="file_name" title="{{ $doc_name }}">{{ $doc_name }}</p></td>
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
                                <button wire:click="deleteDocument({{ $document }})" class="btn btn-danger btn-sm">Apagar</button>
                        @endcan
                    </td>
                </tr>
                {{-- @endif--}}
            @endforeach
            </tbody>
        </table>
        {{ $documents->links() }}

    </div>
</div>
<style>
    .file_name {
        width:250px;
        margin:0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
