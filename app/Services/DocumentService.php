<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DocumentService
{
    public function can(Document $document, string $action): void
    {
        if (!$this->canAccess($document, $action)) {
            abort(405);
        }
    }

    public function canAccess(Document $document, string $action): bool
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

    public function createDocument(string $name): Document
    {
        $document = Document::create([
            "path" => $name,
        ]);

        $document->save();
        return $document;
    }

    public function createAuthorPermission($document)
    {
        $authorPermission = Permission::create([
            'view' => 1,
            'update' => 1,
            'delete' => 1,
            'download' => 1,
            'document_id' => $document->id,
            'user_id' => Auth::user()->id,
        ]);

        $authorPermission->save();
    }

    public function updateDocument(Document $document, string $name)
    {
        $document->update([
            "path" => $name,
        ]);
    }
}
