@extends('layouts.simple')

@section('main-content')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    Alterar documento
                </div>
                <br>

                <form action="{{ route('documents.update', ['document' => $document]) }}" method="post">
                    @method('PUT')
                    @csrf

                    <fildset>
                        Nome: <input type="text" name="name" id="" class="form-control"
                                     value="{{ old('name', $document->path) }}"><br>
                        @error('name') <span class="text-danger">{{ $message }}</span><br>@enderror
                    </fildset>

                    <fildset>
                        MetadataTypes:
                        <br>
                        <label for="add_metadataType">adicionar metadataType? (selecionar para sim, caso contrário,
                            remove o metadataType)</label>
                        <input type="checkbox" id="add_metadataType" name="add_metadataType" value="1">
                        <select name="metadataType_id" id="" class="form-control">
                            @foreach($metadataTypes as $metadataType)
                                @if($document->metadataTypes()->count() > 0 && $document->metadataTypes->contains($metadataType->id))
                                    <option value="{{ $metadataType->id }}" selected>{{ $metadataType->name }}(atual)
                                    </option>
                                @else
                                    <option value="{{ $metadataType->id }}">{{ $metadataType->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>

                        Valor:
                        <input type="text" name="value" class="form-control">

                        <br>
                        @error('metadataTypes') <span class="text-danger">{{ $message }}</span><br>@enderror
                    </fildset>

                    <button type="submit" class="btn btn-success btn-lg">Guardar Modificações</button>
                </form>
            </div>
        </div>
    </div>
@endsection
