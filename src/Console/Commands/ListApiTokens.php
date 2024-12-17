<?php

namespace Matbcvo\LaravelTokenAuth\Console\Commands;

use Illuminate\Console\Command;
use Matbcvo\LaravelTokenAuth\Models\ApiToken;

class ListApiTokens extends Command
{
    protected $signature = 'api-token:list';

    protected $description = 'List all API tokens';

    public function handle(): void
    {
        $tokens = ApiToken::all(['id', 'name', 'token', 'expires_at', 'created_at']);

        if ($tokens->isEmpty()) {
            $this->info('No API tokens found.');

            return;
        }

        $this->table(
            ['ID', 'Name', 'Token', 'Expires At', 'Created At'],
            $tokens->map(function ($token) {
                return [
                    'id' => $token->id,
                    'name' => $token->name,
                    'token' => $token->token,
                    'expires_at' => $token->expires_at ? $token->expires_at->toDateTimeString() : 'Never',
                    'created_at' => $token->created_at ? $token->created_at->toDateTimeString() : 'N/A',
                ];
            })->toArray()
        );
    }
}
