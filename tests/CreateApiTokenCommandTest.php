<?php

namespace Matbcvo\LaravelTokenAuth\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CreateApiTokenCommandTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_new_api_token()
    {
        // Run the command
        Artisan::call('api-token:create', ['name' => 'Test Token', '--expires' => 60]);

        // Fetch the token from the database
        $token = DB::table('api_tokens')->first();

        $this->assertNotNull($token, 'API Token was not created');
        $this->assertEquals('Test Token', $token->name);
        $this->assertNotNull($token->token);
        $this->assertNotNull($token->expires_at);
    }
}
