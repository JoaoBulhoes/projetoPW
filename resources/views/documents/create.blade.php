@extends('layouts.autenticado')
@section('main-content')

    <form action="{{ route('documents.store') }}" method="post">
        @csrf

{{--        Name: <input type="text" name="name" required class="form-control"><br>--}}
{{--        @error('name') <span class="text-danger">{{ $message }}</span><br>@enderror--}}

        Name: <input type="file" accept=".doc, .docx, .pptx, .pdf, xlsx" name="name" required class="form-control"><br>
        @error('name') <span class="text-danger">{{ $message }}</span><br>@enderror

        MetadataType:
        <select name="metadataType_id" id="" class="form-control">
            @foreach ($metadataTypes as $metadataType)
                <option value="{{ $metadataType->id }}">{{ $metadataType->name }}</option>
            @endforeach
        </select>
        <br>
        @error('metadataType_id') <span class="text-danger">{{ $message }}</span><br>@enderror

        MetadaType value: <input type="text" name="metadataType_value" required class="form-control"><br>
        @error('name') <span class="text-danger">{{ $message }}</span><br>@enderror

        <button type="submit" class="btn btn-success btn-lg">Criar Documento</button>
    </form>

@endsection
