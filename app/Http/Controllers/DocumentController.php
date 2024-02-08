<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Document;
use App\Models\MetadataType;
use App\Models\User;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::orderBy('id')->paginate(25);
        return view(
            'documents.index',
            [
                'documents' => $documents
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $metadataTypes = MetadataType::all();
        return view(
            'documents.create',
            [
                'metadataTypes' => $metadataTypes
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('file');

        $fileExtension = $file->getClientOriginalExtension();
        $filePath = $file->storeAs('uploaded_files', $request->name . '.' . $fileExtension);
        $document = DocumentService::createDocument($filePath);

        DocumentService::setMainAtributes($document, $request->name, $fileExtension);

        DocumentService::createAuthorPermission($document);

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        DocumentService::can($document, "view");
        $metadataTypeInfo = DocumentService::getDocumentMetadataTypes($document);

        return view(
            'documents.show',
            [
                'document' => $document,
                'metadataTypeInfo' => $metadataTypeInfo
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        DocumentService::can($document, "update");

        $metadataTypes = MetadataType::all();
        $users = User::all();
        $departments = Department::all();

        return view(
            'documents.edit',
            [
                'document' => $document,
                'metadataTypes' => $metadataTypes,
                'users' => $users,
                'departments' => $departments
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        DocumentService::can($document, "update");

        DocumentService::changeName($document, $request->name);

        if (!$request->metadataType_id) {
            abort(404);
        }

        $addUserPerm = 0;
        if ($request->addUserPermission) {
            $addUserPerm = $request->addUserPermission;
        }

        $addDepartmentPerm = 0;
        if ($request->addDepartmentPermission) {
            $addDepartmentPerm = $request->addDepartmentPermission;
        }

        DocumentService::addUserPermission($document, $request->userId, $request->userPermissionType, $addUserPerm);

        DocumentService::addDepartmentPermission($document, $request->departmentId, $request->departmentPermissionType, $addDepartmentPerm);

        $document->metadataTypes()->detach($request->metadataType_id);

        if ($request->add_metadataType && !$document->metadataTypes->contains($request->metadataType_id)) {
            $document->metadataTypes()->attach($request->metadataType_id, ['value' => $request->mdataValue]);
        }

        $document->save();

        return redirect()->route('documents.show', ['document' => $document]);
    }

    public function download(Document $document)
    {
        if (Storage::exists($document->path)) {
            return Storage::download($document->path);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        DocumentService::can($document, "delete");

        $document->delete();
        return redirect()->route('documents.index');
    }

}
