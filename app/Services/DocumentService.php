<?php

namespace App\Services;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DocumentService
{
    public function can(Document $document, String $action): void
    {
        if (!$this->canAccess($document, $action)){
            abort(405);
        };
    }

    public function canAccess(Document $document, String $action): bool
    {
        $queryResult = User::query()
            ->join("permissions", "users.id", "=", "permissions.user_id")
            ->join("documents", "permissions.document_id", "=", "documents.id")
            ->where("permissions.user_id", "=", Auth::user()->id)
            ->where("permissions.document_id", "=", $document->id)
            ->select("permissions.*")->get();

        if ($queryResult->count() > 0) {
            return $queryResult[0][$action] == "1";
        }

        return false;
    }
}
