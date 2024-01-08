<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function is_admin(User $user): bool
    {
        $queryResult = User::query()
            ->join("profile_user", "users.id", "=", "profile_user.user_id")
            ->join("profiles", "profile_user.profile_id", "=", "profiles.id")
            ->where("profile_user.user_id", "=", $user->id)
            ->select("profiles.name")->get();

        if ($queryResult->count() > 0) {
            return $queryResult[0]->name == "admin";
        }

        return false;
    }

    public function updateUser(User $user, string $name, string $email)
    {
        $user->update([
            "name" => $name,
            "email" => $email,
        ]);
    }

    public function createUser(string $name, string $email, string $password): User
    {
        return User::create([
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password),
        ]);

    }

    public function can(string $action, string $model): void
    {
        if (!Auth::user()->can($action, $model)) {
            abort(403);
        }
    }
}
