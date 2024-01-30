<?php

namespace App\Policies;

use App\Models\User;
use App\Services\UserService;

class MetadataTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return UserService::is_admin($user);
    }

    public function delete(User $user): bool
    {
        return UserService::is_admin($user);
    }
}
