# Laravel Token Auth

A simple Laravel package to manage API tokens using Artisan commands.

## Features

- Create API tokens: Generate and store new API tokens.
- List API tokens: View existing tokens with their details.
- Delete API tokens: Remove existing tokens with confirmation prompts.

## Installation

Install the package via Composer:

```bash
composer require matbcvo/laravel-token-auth
```

### Run migrations

To create the `api_tokens` table in your database:

```bash
php artisan migrate
```

## Commands

This package provides the following Artisan commands:

### Create a new API token

To generate and save a new API token, use the following command:

```bash
php artisan api-token:create {name} {--expires=}
```

Parameters:

- `name` (required):
This is the descriptive name for the token, useful for identifying its purpose.

- `--expires` (optional):
The token's expiration time in minutes. If not provided, the token will not expire.

### List all API tokens

View all existing API tokens:

```bash
php artisan api-token:list
```

### Delete an API token

Delete a specific API token by its ID:

```bash
php artisan api-token:delete {id}
```

You’ll be asked to confirm before deletion.

## Configuration

The package provides a configuration file to customize its behavior. To publish the configuration file, run:

```bash
php artisan vendor:publish --tag=laravel-token-auth-config
```

### Available configuration options

The configuration file includes the following options:

- Token length

    Defines the length of the API token. By default, it is set to 60 characters.

    ```php
    'token_length' => 60,
    ```

## Contribution

Contributions are welcome! If you encounter issues or have feature requests, please submit them via GitHub issues.

## License

This package is open-source and available under the MIT License.