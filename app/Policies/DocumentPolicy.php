<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        $queryResult = User::query()
            ->join("permissions", "users.id", "=", "permissions.user_id")
            ->join("documents", "permissions.document_id", "=", "documents.id")
            ->where("permissions.user_id", "=", $user->id)
            ->where("permissions.document_id", "=", $document->id)
            ->select("permissions.read")->get();

        if ($queryResult->count() > 0) {
            return $queryResult[0]->read == "1";
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        $queryResult = User::query()
            ->join("permissions", "users.id", "=", "permissions.user_id")
            ->join("documents", "permissions.document_id", "=", "documents.id")
            ->where("permissions.user_id", "=", $user->id)
            ->where("permissions.document_id", "=", $document->id)
            ->select("permissions.modify")->get();

        if ($queryResult->count() > 0) {
            return $queryResult[0]->modify == "1";
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        $queryResult = User::query()
            ->join("permissions", "users.id", "=", "permissions.user_id")
            ->join("documents", "permissions.document_id", "=", "documents.id")
            ->where("permissions.user_id", "=", $user->id)
            ->where("permissions.document_id", "=", $document->id)
            ->select("permissions.delete")->get();

        if ($queryResult->count() > 0) {
            return $queryResult[0]->delete == "1";
        }

        return false;
    }

    public function download(User $user, Document $document): bool
    {
        $queryResult = User::query()
            ->join("permissions", "users.id", "=", "permissions.user_id")
            ->join("documents", "permissions.document_id", "=", "documents.id")
            ->where("permissions.user_id", "=", $user->id)
            ->where("permissions.document_id", "=", $document->id)
            ->select("permissions.download")->get();

        if ($queryResult->count() > 0) {
            return $queryResult[0]->download == "1";
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        //
    }
}
