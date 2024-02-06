<?php

namespace Tests\Feature;

use App\Services\DocumentService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserApiTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_can_index(): void
    {
        $response = $this->get(
            '/api/users',
            [
                'Accept' => 'application/json',
            ]
        );
        $response->assertStatus(401);


        $user = UserService::createUser("testUser", fake()->email(), "123");
        $token = $user->createToken('can_index_negatico', ['asdf'])->plainTextToken;

        $response = $this->get(
            '/api/users',
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(403);

        $this->refreshApplication();

        $user = UserService::createUser("testUser", fake()->email(), "123");
        $user->profiles()->attach(1);
        $token = $user->createToken('can_index_positivo', ['users:index'])->plainTextToken;

        $response = $this->get(
            '/api/users',
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
        $token = $user->createToken('can_show_negativo', ['asdf'])->plainTextToken;

        $document = DocumentService::createDocument("asdf");

        $response = $this->get(
            '/api/users/' . $document->id,
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
        $token = $user->createToken('can_show_positivo', ['users:show'])->plainTextToken;
        Auth::login($user);

        $response = $this->get(
            '/api/users/' . 30,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        );
        $response->assertStatus(200);
    }

    public function test_can_update_without_permission(): void
    {
        $this->refreshApplication();

        $user = UserService::createUser("testUser", fake()->email(), "123");
        $token = $user->createToken('can_update_negativo', ['asdf'])->plainTextToken;
        Auth::login($user);

        $response = $this->put(
            '/api/users/' . 30,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'name' => 'api name',
                'email' => 'api email'
            ]
        );
        $response->assertStatus(403);
    }

    public function test_can_update_with_permission()
    {
        $this->refreshApplication();

        $user = UserService::createUser("testUser", fake()->email(), "123");
        $token = $user->createToken('can_update_positivo', ['users:update'])->plainTextToken;
        $user->profiles()->attach(1);
        Auth::login($user);

        $response = $this->put(
            '/api/users/' . 30,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'name' => 'api name',
                'email' => 'api email'
            ]
        );
        $response->assertStatus(200);
    }

    public function test_can_delete_without_permission(): void
    {
        $this->refreshApplication();

        $user = UserService::createUser("testUser", fake()->email(), "123");
        $token = $user->createToken('can_delete_negativo', ['asdf'])->plainTextToken;
        Auth::login($user);

        $response = $this->delete(
            '/api/users/' . 30,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        );
        $response->assertStatus(403);
    }

    public function test_can_delete_with_permission()
    {
        $this->refreshApplication();

        $user = UserService::createUser("testUser", fake()->email(), "123");
        $token = $user->createToken('can_delete_positivo', ['users:delete'])->plainTextToken;
        $user->profiles()->attach(1);
        Auth::login($user);

        $response = $this->delete(
            '/api/users/' . 30,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        );
        $response->assertStatus(200);
    }

}
