<div class="row mt-5">
    <div class="col-4">
{{--        <p class="lead">Filtro</p>--}}
        <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="procurar por nome do utilizador">
    </div>

    <div class="col-4">
{{--        <p class="lead">Departamento</p>--}}
        <select wire:model="department" class="form-control" name="department" id="department">
            <option value="">procurar por departamentos</option>
            <option value="1">Contabilidade</option>
        </select>
    </div>

    <div class="col-4">
        @can('create', \App\Models\User::class)
            <p class="text-right">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus fa-fw mr-2"></i>Adicionar Utilizador
                </a>
            </p>
        @endcan
    </div>

    <div class="col">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th class="text-end">Ações</th>
            </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                {{-- @if($user->id !== \Illuminate\Support\Facades\Auth::id())--}}
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-end">
                        <a href="{{ route('users.show', ['user' => $user]) }}"
                           class="btn btn-primary btn-sm">Ver</a>

                        @can('update', $user)
                            <a href="{{ route('users.edit', ['user' => $user]) }}"
                               class="btn btn-warning btn-sm">Modificar</a>
                        @endcan

                        @can('delete', $user)
                            <button wire:click="deleteUser({{ $user }})" class="btn btn-danger btn-sm">Apagar</button>
                        @endcan
                    </td>
                </tr>
                {{-- @endif--}}
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}

    </div>
</div>
