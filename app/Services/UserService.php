<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
}
