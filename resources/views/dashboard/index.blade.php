@extends('layouts.autenticado')

@section('main-content')
    <div class="container">
        <div class="row mt-5">
            <div class="card">
                <strong style="text-align: center">Documents</strong>

                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Data de update</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($documents as $document)
                        {{-- @if($document->id !== \Illuminate\Support\Facades\Auth::id())--}}
                        <tr>
                            <td>{{ $document->id }}</td>
                            @php($doc_name = \App\Services\DocumentService::getName($document))
                            <td><p class="file_name" title="{{ $doc_name }}">{{ $doc_name }}</p></td>
                            <td>{{ $document->updated_at }}</td>
                        </tr>
                        {{-- @endif--}}
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card">
                <strong style="text-align: center">Users</strong>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Data de update</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $user)
                        {{-- @if($user->id !== \Illuminate\Support\Facades\Auth::id())--}}
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                {{ $user->updated_at }}
                            </td>
                        </tr>
                        {{-- @endif--}}
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        .card {
            width: 50%;
        }
        .file_name {
            width:200px;
            margin:0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
