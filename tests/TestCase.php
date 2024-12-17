<?php

namespace Matbcvo\LaravelTokenAuth\Tests;

use Matbcvo\LaravelTokenAuth\LaravelTokenAuthServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [LaravelTokenAuthServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->artisan('migrate');
    }
}
