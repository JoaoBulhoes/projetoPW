@extends('layouts.simple')

@section('main-content')

    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    Alterar utilizador
                </div>
                <br>

                <form action="{{ route('users.update', ['user' => $user]) }}" method="post">
                    @csrf
                    @method('PUT')

                    <fildset>
                        Nome: <input type="text" name="name" id="" class="form-control"
                                     value="{{ old('name', $user->name) }}"><br>
                        @error('nome') <span class="text-danger">{{ $message }}</span><br>@enderror
                    </fildset>

                    <fildset>
                        Departamentos:
                        <br>
                        <label for="add_department">adicionar departamento? (selecionar para sim, caso contrário, remove
                            o
                            departamento)</label>
                        <input type="checkbox" id="add_department" name="add_department" value="1">
                        <select name="department_id" id="" class="form-control">
                            @foreach($departments as $department)
                                @if($user->departments()->count() > 0 && $user->departments->contains($department->id))
                                    <option value="{{ $department->id }}" selected>{{ $department->name }}(atual)
                                    </option>
                                @else
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                        @error('departments') <span class="text-danger">{{ $message }}</span><br>@enderror
                    </fildset>

                    <fildset>
                        Perfis:
                        <br>
                        <label for="add_profile">adicionar perfil? (selecionar para sim, caso contrário, remove o
                            perfil)</label>
                        <input type="checkbox" id="add_profile" name="add_profile" value="1">

                        <select name="profile_id" id="" class="form-control">
                            @foreach($profiles as $profile)
                                @if($user->profiles()->count() > 0 && $user->profiles->contains($profile->id))
                                    <option value="{{ $profile->id }}" selected>{{ $profile->name }} (atual)</option>
                                @else
                                    <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                        @error('departments') <span class="text-danger">{{ $message }}</span><br>@enderror
                        <button type="submit" class="btn btn-success btn-lg">Guardar Modificações</button>
                    </fildset>
                </form>

            </div>
        </div>
    </div>
@endsection
