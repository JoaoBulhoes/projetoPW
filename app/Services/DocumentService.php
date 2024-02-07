<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DocumentService
{

    private static $perm = array(
        1 => "view",
        2 => "update",
        3 => "download",
        4 => "delete",
    );

    public static function can(Document $document, string $action): void
    {
        if (!DocumentService::canAccess($document, $action)) {
            abort(405);
        }
    }

    public static function canAccess(Document $document, string $action): bool
    {
        return DocumentService::userHasAccess($document, $action) || DocumentService::departmentHasAccess($document, $action);
    }

    public static function userHasAccess(Document $document, string $action): bool
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

    public static function departmentHasAccess(Document $document, string $action): bool
    {
        $queryResult = Document::query()
            ->join("department_document", "documents.id", "=", "department_document.document_id")
            ->join("departments", "department_document.department_id", "=", "departments.id")
            ->where("department_document.document_id", "=", $document->id)
            ->select("department_document.*")->get();

        $hasDepartmentPermission = false;
        for ($i = 0; $i < $queryResult->count(); $i++) {
            $department = $queryResult[$i];
            if ($department[$action] == "1" && Auth::user()->departments->contains($department["department_id"])) {
                $hasDepartmentPermission = true;
                break;
            }
        }

        if ($queryResult->count() > 0) {
            return $hasDepartmentPermission;
        }

        return false;
    }

    public static function createDocument(string $path): Document
    {
        $document = Document::create([
            "path" => $path,
        ]);

        $document->save();
        return $document;
    }

    public static function setMainAtributes(Document $document, string $name, string $extension)
    {

        $document->metadataTypes()->attach(1, [
            'value' => $name,
        ]);

        $document->metadataTypes()->attach(2, [
            'value' => $extension,
        ]);

    }

    public static function getDocumentMetadataTypes(Document $document)
    {
        $queryResult = Document::query()
            ->join("document_metadata_type", "document_metadata_type.document_id", "=", "documents.id")
            ->join("metadata_types", "document_metadata_type.metadata_type_id", "=", "metadata_types.id")
            ->where("documents.id", "=", $document->id)
            ->select("document_metadata_type.value", "metadata_types.name")->get();

        return $queryResult;
    }

    public static function createAuthorPermission($document)
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

    public static function addUserPermission(Document $document, string $userId, string $permissionType, string $value = "0")
    {
        $permission = Permission::where("document_id", "=", $document->id)
            ->where("user_id", "=", $userId)
            ->firstOr(function () use ($document, $userId) {
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

        $permission->update([
            DocumentService::$perm[$permissionType] => $value,
        ]);
    }

    public static function addDepartmentPermission(Document $document, string $departmentId, string $permissionType, string $value)
    {
        $document->departments()->detach($departmentId);

        if ($permissionType == 5) {
            $document->departments()->attach($departmentId, [
                "view" => $value,
                "update" => $value,
                "download" => $value,
                "delete" => $value,
            ]);
        } else {
            $document->departments()->attach($departmentId, [
                "view" => 0,
                "update" => 0,
                "download" => 0,
                "delete" => 0,
                DocumentService::$perm[$permissionType] => $value
            ]);
        }
    }

    public static function getName(Document $document): string
    {
        $query = $document->query()
            ->join("document_metadata_type", "documents.id", "=", "document_metadata_type.document_id")
            ->where("document_metadata_type.document_id", $document->id)
            ->where("document_metadata_type.metadata_type_id", 1)
            ->select("document_metadata_type.value")
            ->get();

        return $query[0]["value"];
    }

    public static function changeName(Document $document, string $name)
    {
        $document->update([
            "updated_at" => Carbon::now()
        ]);
        $document->save();

        $document->metadataTypes()->detach(1);
        $document->metadataTypes()->attach(1, [
            'value' => $name,
        ]);
    }
}