<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\MetadataType;
use App\Models\Permission;
use App\Models\User;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $document = Document::create([
            "path" => $request->name,
        ]);

        $document->metadataTypes()->attach($request->metadataType_id, [
            'value' => $request->metadataType_value,
        ]);

        $authorPermission = Permission::create([
            'view' => 1,
            'update' => 1,
            'delete' => 1,
            'download' => 1,
            'document_id' => $document->id,
            'user_id' => Auth::user()->id,
        ]);

        $authorPermission->save();
        $document->save();

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $documentService = new DocumentService();
        $documentService->can($document, "view");

        return view(
            'documents.show',
            [
                'document' => $document
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $documentService = new DocumentService();
        $documentService->can($document, "update");

        $metadataTypes = MetadataType::all();
        return view(
            'documents.edit',
            [
                'document' => $document,
                'metadataTypes' => $metadataTypes
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $documentService = new DocumentService();
        $documentService->can($document, "update");

        $document->update([
            'name' => $request->name,
        ]);

        if (!$request->metadataType_id || !$request->value) {
            abort(404);
        }

        $document->metadataTypes()->detach($request->metadataType_id);

        if ($request->add_metadataType && !$document->metadataTypes->contains($request->metadataType_id)) {
            $document->metadataTypes()->attach($request->metadataType_id, ['value' => $request->value]);
        }

        $document->save();

        return redirect()->route('documents.show', ['document' => $document]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $documentService = new DocumentService();
        $documentService->can($document, "delete");

        $document->delete();
        return redirect()->route('documents.index');
    }
}
