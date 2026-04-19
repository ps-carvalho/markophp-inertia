# Marko Skeleton — Agent Guide

This document is written for AI coding agents. It describes the project architecture, conventions, and workflows so you can work effectively without prior knowledge of the [Marko Framework](https://marko.build).

---

## Project Overview

This is `marko/skeleton`, the official application skeleton for the Marko Framework — a modular PHP framework with attribute-based routing, dependency injection, auto-discovery, and a plugin system.

- **Language:** PHP 8.5+
- **Package Manager:** Composer
- **Entry Points:**
  - Web: `public/index.php`
  - CLI: `vendor/bin/marko`
- **Test Runner:** Pest PHP 4.0 (`vendor/bin/pest`)
- **Dev Server:** `marko up` (PHP built-in server, port 8000)

---

## Directory Structure

```
├── public/index.php      # Web entry point — boots Application and handles the request
├── app/                  # Your application modules (one subdirectory per module)
│   └── foo/              # Example module with its own composer.json and src/
├── modules/              # Third-party modules (same structure as app/)
├── config/               # Root configuration files (PHP files returning arrays)
├── storage/              # Logs, cache, sessions
├── vendor/               # Composer dependencies
├── .env                  # Environment variables (copy from .env.example)
├── .marko/dev.json       # Dev server process state (auto-managed)
├── composer.json         # Project dependencies
└── AGENTS.md             # This file
```

**Key rule:** Every module — whether in `app/`, `modules/`, or `vendor/` — is a directory containing at minimum a `composer.json`. The framework discovers and loads them automatically.

---

## Module System

Marko is built around a first-class module system. Every module is self-contained and declares its own metadata.

### Minimum Module Requirements

A module directory must contain a `composer.json` with:

```json
{
  "name": "app/foo",
  "type": "marko-module",
  "autoload": {
    "psr-4": {
      "App\\Foo\\": "src/"
    }
  },
  "extra": {
    "marko": {
      "module": true
    }
  }
}
```

- `name` — unique package identifier (`vendor/package` format).
- `autoload.psr-4` — standard Composer PSR-4 mapping. Non-vendor modules get a custom `spl_autoload_register` autoloader at runtime.
- `type: marko-module` — optional but conventional.

### Optional `module.php`

For Marko-specific behaviour, add a `module.php` that returns an array:

```php
<?php

declare(strict_types=1);

use Marko\Core\Container\ContainerInterface;

return [
    'enabled' => true,
    'sequence' => [
        'after' => ['other/module'],   // load after these modules
        'before' => ['another/module'], // load before these modules
    ],
    'bindings' => [
        Interface::class => Implementation::class,
        AnotherInterface::class => function (ContainerInterface $container) {
            return new Implementation($container->get(Something::class));
        },
    ],
    'singletons' => [
        Service::class => true,
    ],
    'boot' => function (ContainerInterface $container) {
        // Runs after all modules are registered; dependencies are auto-injected
    },
];
```

The framework resolves module load order using `require` (from `composer.json`), `after`, and `before`.

### Module Discovery Order

1. `vendor/` — Composer-installed Marko packages
2. `modules/` — third-party modules
3. `app/` — application modules

---

## Dependency Injection Container

The framework uses its own lightweight container (`Marko\Core\Container\Container`).

### Key Concepts

- **Bindings** — map an interface to a class name or closure.
- **Singletons** — shared instances.
- **Instances** — pre-built objects registered directly.
- **Preferences** — class-to-class replacements discovered via the `#[Preference]` attribute.
- **Auto-resolution** — the container resolves constructor parameters by type-hint automatically.

### Container Access

```php
$container = $app->container;
$service = $container->get(MyService::class);
```

### Available by Default in the Container

- `Marko\Core\Container\ContainerInterface` — the container itself
- `Marko\Core\Path\ProjectPaths` — paths to base, vendor, app, modules, config, database
- `Marko\Core\Event\EventDispatcherInterface` — event dispatcher
- `Marko\Core\Module\ModuleRepositoryInterface` — module metadata repository
- `Marko\Core\Command\CommandRegistry` — registered CLI commands

---

## Routing

Routing is attribute-based and auto-discovered. Controllers live inside module `src/` directories.

### Defining Routes

```php
<?php

declare(strict_types=1);

namespace App\Foo\Controller;

use Marko\Routing\Attributes\Get;
use Marko\Routing\Attributes\Post;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;

class UserController
{
    #[Get("/users/{id}")]
    public function show(int $id): Response
    {
        return Response::json(['id' => $id]);
    }

    #[Post("/users")]
    public function store(Request $request): Response
    {
        return Response::json(['created' => true]);
    }
}
```

### Available Route Attributes

- `#[Get("/path")]`
- `#[Post("/path")]`
- `#[Put("/path")]`
- `#[Patch("/path")]`
- `#[Delete("/path")]`
- `#[Route("/path", method: "CUSTOM")]` — generic route attribute

### Parameter Resolution

Controller method parameters are resolved in this priority:

1. **Route parameters** — `{name}` segments from the URL
2. **POST data** — parsed body (`application/x-www-form-urlencoded` for PUT/PATCH/DELETE too)
3. **Query string** — `$_GET`
4. **Default value** — if the parameter has one
5. **`null`** — fallback

Type-hint `Request` to inject the current request object.

### Middleware

Apply middleware at class or method level:

```php
use Marko\Routing\Attributes\Middleware;

#[Middleware([AuthMiddleware::class])]
class AdminController
{
    #[Get("/admin")]
    public function index(): Response
    {
        // ...
    }
}
```

Middleware classes must implement `Marko\Routing\Middleware\MiddlewareInterface`:

```php
public function handle(Request $request, callable $next): Response
```

Global middleware (e.g. `Marko\Session\Middleware\SessionMiddleware`) is auto-registered if the corresponding package is installed.

### Response Helpers

```php
new Response(body: 'plain text');
Response::json(['key' => 'value']);
Response::html('<h1>Hello</h1>');
Response::redirect('/other');
```

---

## CLI & Commands

The CLI is invoked via `vendor/bin/marko` (or `marko` if installed globally).

### Built-in Commands

| Command | Description |
|---------|-------------|
| `marko list` | List all available commands |
| `marko module:list` | List discovered modules |
| `marko up` | Start the development server |
| `marko down` | Stop the development server |
| `marko status` | Show dev server status |
| `marko open` | Open the app in a browser |

### Creating Commands

Define a command class with the `#[Command]` attribute:

```php
<?php

declare(strict_types=1);

namespace App\Foo\Command;

use Marko\Core\Attributes\Command;
use Marko\Core\Command\Input;
use Marko\Core\Command\Output;

#[Command(name: 'greet', description: 'Greet a user')]
class GreetCommand
{
    public function execute(Input $input, Output $output): int
    {
        $name = $input->getArgument('name') ?? 'world';
        $output->writeLine("Hello, {$name}!");
        return 0;
    }
}
```

Commands are auto-discovered from all modules. No manual registration is required.

---

## Plugin System

Plugins provide AOP-style method interception.

```php
<?php

declare(strict_types=1);

namespace App\Foo\Plugin;

use Marko\Core\Attributes\Plugin;
use Marko\Core\Attributes\Before;
use Marko\Core\Attributes\After;
use App\Bar\Service\TargetService;

#[Plugin(TargetService::class)]
class TargetServicePlugin
{
    #[Before]
    public function beforeDoSomething(): void
    {
        // Runs before TargetService::doSomething()
    }

    #[After]
    public function afterDoSomething(): void
    {
        // Runs after TargetService::doSomething()
    }
}
```

Plugins are auto-discovered via the `#[Plugin]` attribute.

---

## Observer System

Observers listen to events via the `#[Observer]` attribute.

```php
<?php

declare(strict_types=1);

namespace App\Foo\Observer;

use Marko\Core\Attributes\Observer;
use App\Bar\Event\UserCreated;

#[Observer(UserCreated::class)]
class SendWelcomeEmail
{
    public function handle(UserCreated $event): void
    {
        // ...
    }
}
```

Dispatch events through the event dispatcher (`EventDispatcherInterface`).

---

## Preferences (Class Replacement)

Use the `#[Preference]` attribute to replace one class with another across the entire application:

```php
<?php

declare(strict_types=1);

namespace App\Foo\Preference;

use Marko\Core\Attributes\Preference;
use Marko\SomePackage\Contracts\OriginalInterface;
use App\Foo\Implementation\BetterImplementation;

#[Preference(replaces: OriginalInterface::class)]
class BetterImplementationPreference
{
    // No methods required — the attribute drives replacement
}
```

---

## Configuration

Configuration files are PHP files that return arrays. They live in the `config/` directory at project root or inside module `config/` subdirectories.

The `marko/config` package provides:

- `ConfigLoader` — load a PHP config file
- `ConfigRepository` — merge and access config values
- `ConfigDiscovery` — discover config files across modules

Example config file (`config/app.php`):

```php
<?php

declare(strict_types=1);

return [
    'name' => 'My Application',
    'url' => env('APP_URL', 'http://localhost:8000'),
];
```

---

## Environment Variables

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

The `marko/env` package loads `.env` automatically during boot. Example variables:

```
APP_ENV=local
APP_DEBUG=true
```

---

## Code Style Guidelines

- Every PHP file must start with `<?php` and `declare(strict_types=1);`.
- Use PSR-4 autoloading. Namespace follows the directory structure under `src/`.
- Prefer `readonly` classes and properties where mutation is not needed.
- Use PHP 8.5 property hooks (`public private(set)`) for read-only public access.
- Use constructor property promotion.
- Use PHP 8 attributes for routing, commands, plugins, observers, and preferences.
- Keep controllers thin; delegate business logic to services.

---

## Testing

This project uses **Pest PHP 4.0**.

### Run Tests

```bash
vendor/bin/pest
```

### Writing Tests

There are currently no tests in this skeleton. Add them at project root or inside module directories. Pest will discover `*.php` files in the default test directories.

---

## Build and Development Commands

| Command | Purpose |
|---------|---------|
| `composer install` | Install PHP dependencies |
| `marko up` | Start dev server (http://localhost:8000) |
| `marko down` | Stop dev server |
| `marko status` | Check dev server status |
| `marko open` | Open the app in default browser |
| `vendor/bin/pest` | Run tests |

---

## Security Considerations

- `public/index.php` is the only web-facing file. Point the web server document root to `public/`.
- `storage/` should be writable by the web server/PHP process.
- `.env` contains sensitive values — never commit it. It is already ignored if you add it to `.gitignore`.
- The built-in dev server (`marko up`) is for local development only. Use a production-grade server (nginx, Apache) for deployed environments.
