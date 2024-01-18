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
                        User permissions:
                        <br>
                        <label for="addUserPermission">adicionar permissão a um user? (selecionar para sim, caso
                            contrário,
                            remove a permissão)</label>
                        <input type="checkbox" id="addUserPermission" name="addUserPermission" value="1">
                        <select name="userId" id="" class="form-control">
                            @foreach($users as $user)
{{--                                @if($user->id !== \Illuminate\Support\Facades\Auth::id())--}}
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
{{--                                @endif--}}
                            @endforeach
                        </select>
                        <br>

                        Valor:
                        <select name="permissionType" id="" class="form-control">
                            <option value="1">Ver</option>
                            <option value="2">Modificar</option>
                            <option value="3">Download</option>
                            <option value="4">Apagar</option>
                            <option value="5">Todas as permissões</option>
                        </select>

                        <br>
                        @error('userId') <span class="text-danger">{{ $message }}</span><br>@enderror
                    </fildset>

                    <fildset>
                        MetadataTypes:
                        <br>
                        <label for="add_metadataType">adicionar metadataType? (selecionar para sim, caso contrário,
                            remove o metadataType)</label>
                        <input type="checkbox" id="add_metadataType" name="add_metadataType" value="1">
                        <select name="metadataType_id" id="" class="form-control">
                            @foreach($metadataTypes as $metadataType)
                                @if($metadataType->id > env("DEFAULT_NUMBER_METADATATYPES"))
                                    @if($document->metadataTypes()->count() > 0 && $document->metadataTypes->contains($metadataType->id))
                                        <option value="{{ $metadataType->id }}" selected>{{ $metadataType->name }}
                                            (atual)
                                        </option>
                                    @else
                                        <option value="{{ $metadataType->id }}">{{ $metadataType->name }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                        <br>

                        Valor:
                        <input type="text" name="mdataValue" class="form-control">

                        <br>
                        @error('metadataTypes') <span class="text-danger">{{ $message }}</span><br>@enderror
                    </fildset>

                    <button type="submit" class="btn btn-success btn-lg">Guardar Modificações</button>
                </form>
            </div>
        </div>
    </div>
@endsection
