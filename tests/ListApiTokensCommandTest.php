<?php

namespace Matbcvo\LaravelTokenAuth\Tests;

use Matbcvo\LaravelTokenAuth\Models\ApiToken;

class ListApiTokensCommandTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_lists_all_api_tokens()
    {
        // Create some tokens
        ApiToken::create([
            'name' => 'Token 1',
            'token' => 'token-1',
            'expires_at' => now()->addDay(),
        ]);

        ApiToken::create([
            'name' => 'Token 2',
            'token' => 'token-2',
            'expires_at' => now()->addDays(2),
        ]);

        // Run the list command
        $this->artisan('api-token:list')
            ->expectsTable(
                ['ID', 'Name', 'Token', 'Expires At', 'Created At'],
                [
                    [1, 'Token 1', 'token-1', now()->addDay()->toDateTimeString(), now()->toDateTimeString()],
                    [2, 'Token 2', 'token-2', now()->addDays(2)->toDateTimeString(), now()->toDateTimeString()],
                ]
            )
            ->assertExitCode(0);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_no_api_tokens()
    {
        // Run the list command when no tokens exist
        $this->artisan('api-token:list')
            ->expectsOutput('No API tokens found.')
            ->assertExitCode(0);
    }
}
