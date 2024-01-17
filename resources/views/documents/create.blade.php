@extends('layouts.autenticado')
@section('main-content')

    <form action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        Name: <input type="text" name="name" required class="form-control"><br>
        @error('name') <span class="text-danger">{{ $message }}</span><br>@enderror

        MetadataType:
        <select name="metadataType_id" id="" class="form-control">
            @foreach ($metadataTypes as $metadataType)
                @if($metadataType->id > env('DEFAULT_NUMBER_METADATATYPES'))
                    <option value="{{ $metadataType->id }}">{{ $metadataType->name }}</option>
                @endif
            @endforeach
        </select>
        <br>
        @error('metadataType_id') <span class="text-danger">{{ $message }}</span><br>@enderror

        MetadaType value: <input type="text" name="metadataType_value" required class="form-control"><br>
        @error('name') <span class="text-danger">{{ $message }}</span><br>@enderror

        Ficheiro: <input type="file" name="file" required class="form-control"><br>

        <button type="submit" class="btn btn-success btn-lg">Criar Documento</button>
    </form>

@endsection
