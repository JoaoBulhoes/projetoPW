<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetadataTypeResource;
use App\Http\Resources\MetadataTypeResourceCollection;
use App\Models\MetadataType;
use App\Services\MetadataTypeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MetadataTypeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->tokenCan('metadataTypes:index')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        return new MetadataTypeResourceCollection(MetadataType::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('metadataTypes:create')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        if (!$request->has('name')) {
            return response()->json(['message' => 'Informaçao insuficiente'], 400);
        }

        $metadataTypeService = new MetadataTypeService();
        $metadataType = $metadataTypeService->createMetadataType($request->name);
        return new MetadataTypeResource($metadataType);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('metadataTypes:show')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        try {
            $metadataType = MetadataType::findOrFail($id);
            return new MetadataTypeResource($metadataType);
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
        return response()->json(['message' => 'Ocorreu no servidor'], 503);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('metadataTypes:delete')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        try {
            $metadataType = MetadataType::findOrFail($id);
            $metadataType->delete();

            return response()->json(['message' => 'Apagado com sucesso'], 200);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['message' => 'Não encontrado'], 404);
            }

            return response()->json(['message' => 'Ocorreu um erro de comunicação'], 503);
        }
    }
}
