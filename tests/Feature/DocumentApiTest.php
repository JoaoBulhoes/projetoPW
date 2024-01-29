<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Services\DocumentService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DocumentApiTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_can_index(): void
    {
        $response = $this->get(
            '/api/documents',
            [
                'Accept' => 'application/json',
            ]
        );
        $response->assertStatus(401);

        $userService = new UserService();

        $user = $userService->createUser("user1", "b@b", "123");
        $token = $user->createToken('test_negativo', ['aaaa'])->plainTextToken;

        $response = $this->get(
            '/api/documents',
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(403);

        $this->refreshApplication();

        $user = $userService->createUser("user2", "c@c", "123");
        $user->profiles()->attach(1);
        $token = $user->createToken('test_positivo', ['documents:index'])->plainTextToken;

        $response = $this->get(
            '/api/documents',
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(200);
    }

    public function test_can_view_without_permission(): void
    {
        $this->refreshApplication();
        $userService = new UserService();
        $documentService = new DocumentService();

        $user = $userService->createUser("user3", "b", "123");
        $token = $user->createToken('tn', ['documents:show'])->plainTextToken;

        $document = $documentService->createDocument("asdf");

        $response = $this->get(
            '/api/documents/' . $document->id,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(403);
    }

    public function test_can_view_with_permission(){
        $this->refreshApplication();
        $userService = new UserService();
        $documentService = new DocumentService();

        $user = $userService->createUser("user2", "c", "123");
        $token = $user->createToken('test_positivo', ['documents:show'])->plainTextToken;
        Auth::login($user);

        $document = $documentService->createDocument("path2");
        $documentService->createAuthorPermission($document);

        $response = $this->get(
            '/api/documents/' . $document->id,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(200);
    }

}
