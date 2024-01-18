@extends('layouts.autenticado')
@section('main-content')

    <form action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        Name: <input type="text" name="name" required class="form-control"><br>
        @error('name') <span class="text-danger">{{ $message }}</span><br>@enderror

        Ficheiro: <input type="file" name="file" required class="form-control"><br>

        <button type="submit" class="btn btn-success btn-lg">Criar Documento</button>
    </form>

@endsection
