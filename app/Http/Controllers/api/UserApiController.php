<?php

namespace App\Http\Controllers\api;

use App\Dto\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->tokenCan('users:index')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        return new UserResourceCollection(User::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('users:create')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        if (!$request->has('name') || !$request->has('email') || !$request->has('password')) {
            return response()->json(['message' => 'Informaçao insuficiente'], 400);
        }

        $userService = new UserService();
        $user = $userService->createUser($request->name, $request->email, $request->password);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('users:show')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        try {
            $user = User::findOrFail($id);
            return new userResource($user);
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
        if (!$request->has('name') || !$request->has('email')) {
            return response()->json(['message' => 'Informaçao insuficiente'], 400);
        }

        try {
            $user = User::findOrFail($id);

            $userService = new UserService();
            $userService->updateUser($user, $request->name, $request->email);

            return response()->json(['message' => 'Atualizado com sucesso'], 200);
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
        if (!auth()->user()->tokenCan('users:delete')) {
            return response()->json(['message' => 'FORBIDDEN'], 403);
        }

        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'Apagado com sucesso'], 200);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['message' => 'Não encontrado'], 404);
            }

            return response()->json(['message' => 'Ocorreu um erro de comunicação'], 503);
        }
    }
}
