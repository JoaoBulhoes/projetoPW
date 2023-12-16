@extends('layouts.autenticado')
@section('main-content')

    <form action="{{ route('metadataTypes.store') }}" method="post">
        @csrf

        Name: <input type="text" name="name" required class="form-control"><br>
        @error('name') <span class="text-danger">{{ $message }}</span><br>@enderror

        <button type="submit" class="btn btn-success btn-lg">Criar Tipo de metadata</button>
    </form>


@endsection
