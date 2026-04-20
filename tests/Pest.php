<?php

declare(strict_types=1);

// Marko application test bootstrap

use Marko\Authentication\AuthManager;
use Marko\Authentication\AuthenticatableInterface;
use Marko\Config\ConfigRepository;
use Marko\Core\Path\ProjectPaths;
use Marko\Inertia\Inertia;
use Marko\Inertia\Ssr\SsrClient;
use Marko\Vite\Vite;

function createApplicationInertia(array $config = []): Inertia
{
    $mergedConfig = new ConfigRepository(array_replace_recursive([
        'inertia' => [
            'rootView' => 'app',
            'version' => 'test',
            'ssr' => [
                'enabled' => false,
                'url' => 'http://localhost:13714',
            ],
        ],
        'vite' => [
            'buildDirectory' => 'build',
            'manifestFilename' => '.vite/manifest.json',
            'devServerUrl' => 'http://localhost:5173',
            'devServerStylesheets' => [
                'app/web/resources/css/app.css',
            ],
            'useDevServer' => true,
        ],
    ], $config));

    $vite = new Vite($mergedConfig, new ProjectPaths(dirname(__DIR__)));

    return new Inertia(
        $mergedConfig,
        $vite,
        new SsrClient('http://localhost:13714'),
    );
}

class FakeAuthManager extends AuthManager
{
    public function __construct(
        private bool $attemptResult = false,
        private ?AuthenticatableInterface $fakeUser = null,
    ) {}

    public bool $loggedOut = false;

    /** @param array<string, mixed> $credentials */
    public array $attemptedCredentials = [];

    public function attempt(array $credentials): bool
    {
        $this->attemptedCredentials = $credentials;

        return $this->attemptResult;
    }

    public function logout(): void
    {
        $this->loggedOut = true;
    }

    public function user(): ?AuthenticatableInterface
    {
        return $this->fakeUser;
    }
}
