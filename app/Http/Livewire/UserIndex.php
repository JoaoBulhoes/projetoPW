<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Services\UserService;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    public $search = '';
    public $department = '';
    use WithPagination;

    public function render()
    {
        $query = User::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $users = $query->paginate(25);

        return view('livewire.user-index', [
                'users' => $users,
            ]
        )->extends('layouts.autenticado')->section('main-content');
    }

    public function deleteUser(User $user)
    {
        UserService::can("delete", User::class);

        $user->delete();
    }
}
