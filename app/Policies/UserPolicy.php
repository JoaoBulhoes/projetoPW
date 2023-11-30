<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $queryResult = User::query()
            ->join("profile_user", "users.id", "=", "profile_user.user_id")
            ->join("profiles", "profile_user.profile_id", "=", "profiles.id")
            ->where("profile_user.user_id", "=", $user->id)
            ->select("profiles.name")->get();

        return $queryResult[0]->name == "admin";
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        $queryResult = User::query()
            ->join("profile_user", "users.id", "=", "profile_user.user_id")
            ->join("profiles", "profile_user.profile_id", "=", "profiles.id")
            ->where("profile_user.user_id", "=", $user->id)
            ->select("profiles.name")->get();

        return $queryResult[0]->name == "admin";
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        $queryResult = User::query()
            ->join("profile_user", "users.id", "=", "profile_user.user_id")
            ->join("profiles", "profile_user.profile_id", "=", "profiles.id")
            ->where("profile_user.user_id", "=", $user->id)
            ->select("profiles.name")->get();

        return $queryResult[0]->name == "admin";
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        //
    }
}
