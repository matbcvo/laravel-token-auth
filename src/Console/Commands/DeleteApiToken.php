<?php

namespace Matbcvo\LaravelTokenAuth\Console\Commands;

use Illuminate\Console\Command;
use Matbcvo\LaravelTokenAuth\Models\ApiToken;

class DeleteApiToken extends Command
{
    protected $signature = 'api-token:delete {id : The ID of the token to delete}';

    protected $description = 'Delete an API token by its ID';

    public function handle(): int
    {
        $id = (int) $this->argument('id');

        $token = ApiToken::find($id);

        if (! $token) {
            $this->error("API token with ID {$id} not found.");

            return 1;
        }

        if (! $this->confirm("Are you sure you want to delete the token '{$token->name}' (ID: {$id})?")) {
            $this->info('Deletion cancelled.');

            return 0;
        }

        $token->delete();
        $this->info("API token '{$token->name}' (ID: {$id}) has been deleted.");

        return 0;
    }
}
