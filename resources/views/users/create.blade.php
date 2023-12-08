@extends('layouts.autenticado')
@section('main-content')

    <form action="{{ route('users.store') }}" method="post">
        @csrf

        Name: <input type="text" name="name" required class="form-control"><br>
        @error('name') <span class="text-danger">{{ $message }}</span><br>@enderror

        Email: <input type="email" name="email" required class="form-control"><br>
        @error('email') <span class="text-danger">{{ $message }}</span><br>@enderror

        Password: <input type="password" name="password" required class="form-control"><br>
        @error('password') <span class="text-danger">{{ $message }}</span><br>@enderror

        Department:
        <select name="department_id" id="" class="form-control">
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
        <br>
        @error('department') <span class="text-danger">{{ $message }}</span><br>@enderror

        Profile:
        <select name="profile_id" id="" class="form-control">
            @foreach ($profiles as $profile)
                <option value="{{ $profile->id }}">{{ $profile->name }}</option>
            @endforeach
        </select>
        <br>
        @error('profile') <span class="text-danger">{{ $message }}</span><br>@enderror

        <button type="submit" class="btn btn-success btn-lg">Criar Utilizador</button>
    </form>


@endsection
