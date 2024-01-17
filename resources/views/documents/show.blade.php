@extends('layouts.simple')

@section('main-content')

    <h1 class="text-md-center" style="color: white">Documento</h1>

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
                            <th>Path</th>
                            <th>Metadata Types</th>
                            <th>Values</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>{{ $document->path }}</td>
                                <td>
                                    @for($i = 0; $i < $metadataTypeInfo->count(); $i++)
                                        <p>{{ $metadataTypeInfo[$i]["name"] }}</p>
                                    @endfor
                                </td>
                                <td>
                                    @for($i = 0; $i < $metadataTypeInfo->count(); $i++)
                                        <p>{{ $metadataTypeInfo[$i]["value"] }}</p>
                                    @endfor
                                </td>
                        </tr>
                        </tbody>
                    </table>
                </card-body>
            </div>
        </div>
    </div>

@endsection
