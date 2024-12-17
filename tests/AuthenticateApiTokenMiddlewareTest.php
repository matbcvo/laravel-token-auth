<?php

namespace Matbcvo\LaravelTokenAuth\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Matbcvo\LaravelTokenAuth\Models\ApiToken;
use Matbcvo\LaravelTokenAuth\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiTokenMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Define a route protected by the middleware
        Route::middleware('auth.token')->get('/protected-route', function () {
            return response()->json(['message' => 'Access granted']);
        });
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_denies_access_with_invalid_token()
    {
        $response = $this->withHeader('Authorization', 'Bearer invalid-token')
            ->get('/protected-route');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(['error' => 'Unauthorized']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_allows_access_with_valid_token()
    {
        // Create a valid token
        $apiToken = ApiToken::create([
            'name' => 'Valid Token',
            'token' => 'valid-token',
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send request with the valid token
        $response = $this->withHeader('Authorization', 'Bearer valid-token')
            ->get('/protected-route');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Access granted']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_denies_access_with_expired_token()
    {
        // Create an expired token
        $apiToken = ApiToken::create([
            'name' => 'Expired Token',
            'token' => 'expired-token',
            'expires_at' => now()->subMinutes(10),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer expired-token')
            ->get('/protected-route');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(['error' => 'Unauthorized']);
    }
}
