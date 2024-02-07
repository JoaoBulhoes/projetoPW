<?php

namespace App\Http\Livewire;

use App\Models\Department;
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
            $query->where('users.name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->department)) {
            $query->join("department_user", "users.id", "=", "department_user.user_id")
                ->join("departments", "department_user.department_id", "=", "departments.id")
                ->where('departments.id', $this->department);
        }

        $query->select("users.*");

        $users = $query->paginate(25);

        $departments = Department::all();
        return view('livewire.user-index', [
                'users' => $users,
                'departments' => $departments,
            ]
        )->extends('layouts.autenticado')->section('main-content');
    }

    public function deleteUser(User $user)
    {
        UserService::can("delete", User::class);

        $user->delete();
    }
}
