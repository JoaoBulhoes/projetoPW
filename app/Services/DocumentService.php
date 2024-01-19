<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Permission;
use App\Models\User;
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

        $queryResult2 = Document::query()
            ->join("department_document", "documents.id", "=", "department_document.document_id")
            ->join("departments", "department_document.document_id", "=", "departments.id")
            ->where("department_document.document_id", "=", $document->id)
            ->select("department_document.*")->get();

        $hasDepartmentPermission = false;
        for ($i = 0; $i < $queryResult2->count(); $i++) {
            if ($queryResult2[$i][$action] == "1"){
                $hasDepartmentPermission = true;
                break;
            }
        }

        if ($queryResult->count() > 0) {
            return $queryResult[0][$action] == "1" || $hasDepartmentPermission;
        }

        if ($queryResult2->count() > 0) {
            return $hasDepartmentPermission;
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

    public function setMainAtributes(Document $document, string $name, string $extension)
    {

        $document->metadataTypes()->attach(1, [
            'value' => $name,
        ]);

        $document->metadataTypes()->attach(2, [
            'value' => $extension,
        ]);

    }

    public function getDocumentMetadataTypes(Document $document)
    {
        $queryResult = Document::query()
            ->join("document_metadata_type", "document_metadata_type.document_id", "=", "documents.id")
            ->join("metadata_types", "document_metadata_type.metadata_type_id", "=", "metadata_types.id")
            ->where("documents.id", "=", $document->id)
            ->select("document_metadata_type.value", "metadata_types.name")->get();

        return $queryResult;
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

    public function addUserPermission(Document $document, string $userId, string $permissionType, string $value="0")
    {
        $permission = Permission::where("document_id", "=", $document->id)
            ->where("user_id", "=", $userId)
            ->firstOr(function ($document, $userId) {
                Permission::create([
                    "view" => 0,
                    "update" => 0,
                    "download" => 0,
                    "delete" => 0,
                    "document_id" => $document->id,
                    "user_id" => $userId,
                ]);
            });

        if ($permissionType == 5) {
            $permission->update([
                "view" => $value,
                "update" => $value,
                "download" => $value,
                "delete" => $value,
            ]);
            return;
        }

        $perm = array(
            1 => "view",
            2 => "update",
            3 => "download",
            4 => "delete",
        );

        $permission->update([
            $perm[$permissionType] => $value,
        ]);
    }

}
