<?php

namespace Matbcvo\LaravelTokenAuth\Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Matbcvo\LaravelTokenAuth\Models\ApiToken;
use Matbcvo\LaravelTokenAuth\Tests\TestCase;

class ApiTokenTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_registers_api_token_commands()
    {
        $commands = Artisan::all();

        $this->assertArrayHasKey('api-token:create', $commands);
        $this->assertArrayHasKey('api-token:delete', $commands);
        $this->assertArrayHasKey('api-token:list', $commands);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_checks_if_a_token_is_expired()
    {
        $token = ApiToken::create([
            'name' => 'Test Token',
            'token' => 'test-token',
            'expires_at' => now()->subMinutes(1), // Expired
        ]);

        $this->assertTrue($token->isExpired());

        $validToken = ApiToken::create([
            'name' => 'Valid Token',
            'token' => 'valid-token',
            'expires_at' => now()->addMinutes(10),
        ]);

        $this->assertFalse($validToken->isExpired());
    }
}
