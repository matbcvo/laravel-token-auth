<?php

namespace Matbcvo\LaravelTokenAuth\Tests;

use Matbcvo\LaravelTokenAuth\Models\ApiToken;

class DeleteApiTokenCommandTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_deletes_an_existing_api_token(): void
    {
        // Create a test token
        $token = ApiToken::create([
            'name' => 'Test Token',
            'token' => 'test-token',
            'expires_at' => now()->addDay(),
        ]);

        // Run the command and confirm deletion
        $this->artisan('api-token:delete', ['id' => $token->id])
            ->expectsConfirmation("Are you sure you want to delete the token 'Test Token' (ID: {$token->id})?", 'yes') // Match the confirmation message
            ->expectsOutput("API token 'Test Token' (ID: {$token->id}) has been deleted.")
            ->assertExitCode(0);

        // Token should be deleted
        $this->assertDatabaseMissing('api_tokens', ['id' => $token->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_non_existing_api_token(): void
    {
        $nonExistentId = 999;

        // Attempt to delete a non-existing token
        $this->artisan('api-token:delete', ['id' => $nonExistentId])
            ->expectsOutput("API token with ID {$nonExistentId} not found.")
            ->assertExitCode(1); // Ensure it returns a non-zero exit code
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_cancels_deletion_of_an_api_token(): void
    {
        // Create a test token
        $token = ApiToken::create([
            'name' => 'Test Token',
            'token' => 'test-token',
            'expires_at' => now()->addDay(),
        ]);

        // Ensure the token is in the database before starting
        $this->assertDatabaseHas('api_tokens', ['id' => $token->id]);

        // Run the command and cancel deletion
        $this->artisan('api-token:delete', ['id' => $token->id])
            ->expectsConfirmation("Are you sure you want to delete the token 'Test Token' (ID: {$token->id})?", 'no')
            ->expectsOutput('Deletion cancelled.')
            ->assertExitCode(0);

        // Token should still exist
        $this->assertDatabaseHas('api_tokens', ['id' => $token->id]);
    }
}
