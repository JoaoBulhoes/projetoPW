<?php

namespace App\Http\Controllers;

use App\Models\MetadataType;
use App\Services\MetadataTypeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class MetadataTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metadataTypes = MetadataType::orderBy('name')->paginate(25);
        return view(
            'metadataTypes.index',
            [
                'metadataTypes' => $metadataTypes,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userService = new UserService();
        $userService->can("create", MetadataType::class);

        return view('metadataTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userService = new UserService();
        $userService->can("create", MetadataType::class);

        $metadataTypeService = new MetadataTypeService();
        $metadataType = $metadataTypeService->createMetadataType($request->name);

        $metadataType->save();

        return redirect()->route('metadataTypes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MetadataType $metadataType)
    {
        $userService = new UserService();
        $userService->can("delete", MetadataType::class);

        $metadataType->delete();
        return redirect()->route('metadataTypes.index');
    }
}
