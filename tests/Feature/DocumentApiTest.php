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


        $user = UserService::createUser("testUser", fake()->email(), "123");
        $token = $user->createToken('can_index_negatico', ['aaaa'])->plainTextToken;

        $response = $this->get(
            '/api/documents',
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(403);

        $this->refreshApplication();

        $user = UserService::createUser("testUser", fake()->email(), "123");
        $user->profiles()->attach(1);
        $token = $user->createToken('can_index_positivo', ['documents:index'])->plainTextToken;

        $response = $this->get(
            '/api/documents',
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(200);
    }

    public function test_can_show_without_permission(): void
    {
        $this->refreshApplication();

        $user = UserService::createUser("testUser", fake()->email(), "123");
        $token = $user->createToken('can_view_negativo', ['documents:show'])->plainTextToken;

        $document = DocumentService::createDocument("asdf");

        $response = $this->get(
            '/api/documents/' . $document->id,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(403);
    }

    public function test_can_show_with_permission()
    {
        $this->refreshApplication();

        $user = UserService::createUser("testUser", fake()->email(), "123");
        $token = $user->createToken('can_view_positivo', ['documents:show'])->plainTextToken;
        Auth::login($user);

        $document = DocumentService::createDocument("path2");
        DocumentService::createAuthorPermission($document);

        $response = $this->get(
            '/api/documents/' . $document->id,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(200);
    }
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
