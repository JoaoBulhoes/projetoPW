<?php

namespace App\Livewire\Users;

use App\Models\DocumentPermition;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndexLivewire extends Component
{
    public $search = '';
    use WithPagination;

    public function render()
    {
        $query = User::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $users = $query->paginate(5);

        return view('livewire.userIndex', [
                'users' => $users,
            ]
        )->extends('layouts.autenticado')->section('main-content');
    }


}
