<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use App\Services\DocumentService;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function index(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        $documentService = new DocumentService();
        return $documentService->canAccess($document, "view");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        $documentService = new DocumentService();
        return $documentService->canAccess($document, "update");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        $documentService = new DocumentService();
        return $documentService->canAccess($document, "delete");
    }

    public function download(User $user, Document $document): bool
    {
        $documentService = new DocumentService();
        return $documentService->canAccess($document, "download");
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
