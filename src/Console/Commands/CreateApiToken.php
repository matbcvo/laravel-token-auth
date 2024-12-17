<?php

namespace Matbcvo\LaravelTokenAuth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Matbcvo\LaravelTokenAuth\Models\ApiToken;

class CreateApiToken extends Command
{
    protected $signature = 'api-token:create {name} {--expires=}';

    protected $description = 'Create a new API token';

    public function handle(): void
    {
        $name = $this->argument('name');
        $expires = $this->option('expires') ? now()->addMinutes((int) $this->option('expires')) : null;

        // Retrieve the token length from the configuration
        $tokenLength = is_numeric(Config::get('laravel-token-auth.token_length')) ? (int) Config::get('laravel-token-auth.token_length') : 60; // Default to 60 if not set

        $token = ApiToken::create([
            'name' => $name,
            'token' => Str::random($tokenLength),
            'expires_at' => $expires,
        ]);

        $this->info("Token created: {$token->token}");
    }
}
