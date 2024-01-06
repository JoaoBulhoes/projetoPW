<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\DocumentResourceCollection;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->tokenCan('documents:index')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        return new DocumentResourceCollection(Document::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->tokenCan('documents:create')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        $documentService = new DocumentService();
        $document = $documentService->createDocument($request->name);
        $documentService->createAuthorPermission($document);

        return new DocumentResource($document);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $documentService = new DocumentService();

        try {
            $document = Document::findOrFail($id);
            if (!Auth::user()->tokenCan('documents:show') || !$documentService->canAccess($document, "view")) {
                return response()->json(['message' => 'FORBIDDEN'], 403);
            }

            return new DocumentResource($document);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['message' => 'Não encontrado'], 404);
            }

            return response()->json(['message' => 'Ocorreu um erro de comunicação'], 503);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$request->has("name")) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }
        $documentService = new DocumentService();

        try {
            $document = Document::findOrFail($id);
            if (!Auth::user()->tokenCan('documents:update') || !$documentService->canAccess($document, "update")) {
                return response()->json(['message' => 'FORBIDDEN'], 403);
            }

            $documentService->updateDocument($document, $request->name);
            $document->save();

            return new DocumentResource($document);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['message' => 'Não encontrado'], 404);
            }

            return response()->json(['message' => 'Ocorreu um erro de comunicação'], 503);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $documentService = new DocumentService();

        try {
            $document = Document::findOrFail($id);
            if (!Auth::user()->tokenCan('documents:delete') || !$documentService->canAccess($document, "delete")) {
                return response()->json(['message' => 'FORBIDDEN'], 403);
            }
            $document->delete();

            return response()->json(['message' => 'Apagado com sucesso'], 200);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['message' => 'Não encontrado'], 404);
            }

            return response()->json(['message' => 'Ocorreu um erro de comunicação'], 503);
        }
    }
}
