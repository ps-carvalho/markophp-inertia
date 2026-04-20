<?php

declare(strict_types=1);

use Marko\Config\ConfigRepository;
use Marko\Core\Path\ProjectPaths;
use Marko\Inertia\Inertia;
use Marko\Inertia\Ssr\SsrClient;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;
use Marko\Vite\Vite;

beforeEach(function () {
    $this->basePath = dirname(__DIR__, 4);
    $this->paths = new ProjectPaths($this->basePath);
});

function createInertia(array $config = [], array $viteConfig = []): Inertia
{
    $mergedConfig = new ConfigRepository(array_merge([
        'inertia' => [
            'rootView' => 'app',
            'version' => '1.0',
            'ssr' => [
                'enabled' => false,
                'url' => 'http://localhost:13714',
            ],
        ],
        'vite' => array_merge([
            'buildDirectory' => 'build',
            'manifestFilename' => '.vite/manifest.json',
            'devServerUrl' => 'http://localhost:5173',
            'useDevServer' => false,
        ], $viteConfig),
    ], $config));

    $paths = new ProjectPaths(dirname(__DIR__, 4));
    $vite = new Vite($mergedConfig, $paths);
    $ssrClient = new SsrClient('http://localhost:13714');

    return new Inertia($mergedConfig, $vite, $ssrClient);
}

test('inertia returns json for inertia requests', function () {
    $inertia = createInertia();
    $request = new Request(server: ['HTTP_X_INERTIA' => 'true']);

    $response = $inertia->render($request, 'Dashboard', ['user' => ['name' => 'Test']]);

    expect($response->statusCode())->toBe(200);
    expect($response->headers()['Content-Type'])->toBe('application/json');

    $data = json_decode($response->body(), true);
    expect($data['component'])->toBe('Dashboard');
    expect($data['props']['user']['name'])->toBe('Test');
});

test('inertia returns html for non-inertia requests', function () {
    $inertia = createInertia();
    $request = new Request();

    $response = $inertia->render($request, 'Dashboard', ['user' => ['name' => 'Test']]);

    expect($response->statusCode())->toBe(200);
    expect($response->headers()['Content-Type'])->toBe('text/html; charset=utf-8');
    expect($response->body())->toContain('<!DOCTYPE html>');
    expect($response->body())->toContain('<script data-page="app" type="application/json">');
    expect($response->body())->toContain('data-page=');
});

test('inertia html can target a custom vite asset entry', function () {
    $inertia = createInertia(viteConfig: [
        'devServerUrl' => 'http://localhost:5173',
        'devServerStylesheets' => [],
        'useDevServer' => true,
    ]);
    $request = new Request();

    $response = $inertia->render(
        request: $request,
        component: 'ReactHome',
        assetEntry: 'app/react-web/resources/js/app.jsx',
    );

    expect($response->body())->toContain('http://localhost:5173/app/react-web/resources/js/app.jsx');
    expect($response->body())->not->toContain('app/web/resources/js/app.js');
});

test('inertia merges shared data with page props', function () {
    $inertia = createInertia();
    $inertia->share('flash', ['message' => 'Hello']);

    $request = new Request(server: ['HTTP_X_INERTIA' => 'true']);
    $response = $inertia->render($request, 'Dashboard', ['user' => ['name' => 'Test']]);

    $data = json_decode($response->body(), true);
    expect($data['props']['flash']['message'])->toBe('Hello');
    expect($data['props']['user']['name'])->toBe('Test');
});

test('inertia location redirect returns x-inertia-location header', function () {
    $inertia = createInertia();
    $response = $inertia->location('https://example.com');

    expect($response->headers()['X-Inertia-Location'])->toBe('https://example.com');
});

test('inertia resolves lazy props on full load', function () {
    $inertia = createInertia();
    $called = false;

    $request = new Request(server: ['HTTP_X_INERTIA' => 'true']);
    $response = $inertia->render($request, 'Dashboard', [
        'user' => ['name' => 'Test'],
        'expensive' => function () use (&$called) {
            $called = true;
            return ['data' => 'loaded'];
        },
    ]);

    expect($called)->toBeTrue();

    $data = json_decode($response->body(), true);
    expect($data['props']['expensive']['data'])->toBe('loaded');
});

test('inertia skips lazy props on partial reload when not requested', function () {
    $inertia = createInertia();
    $called = false;

    $request = new Request(server: [
        'HTTP_X_INERTIA' => 'true',
        'HTTP_X_INERTIA_PARTIAL_COMPONENT' => 'Dashboard',
        'HTTP_X_INERTIA_PARTIAL_DATA' => 'user',
    ]);

    $response = $inertia->render($request, 'Dashboard', [
        'user' => ['name' => 'Test'],
        'expensive' => function () use (&$called) {
            $called = true;
            return ['data' => 'loaded'];
        },
    ]);

    expect($called)->toBeFalse();

    $data = json_decode($response->body(), true);
    expect($data['props']['user']['name'])->toBe('Test');
    expect($data['props'])->not->toHaveKey('expensive');
});

test('inertia includes flash in partial reloads', function () {
    $inertia = createInertia();
    $inertia->flash('success', 'Saved!');

    $request = new Request(server: [
        'HTTP_X_INERTIA' => 'true',
        'HTTP_X_INERTIA_PARTIAL_COMPONENT' => 'Dashboard',
        'HTTP_X_INERTIA_PARTIAL_DATA' => 'user',
    ]);

    $response = $inertia->render($request, 'Dashboard', [
        'user' => ['name' => 'Test'],
    ]);

    $data = json_decode($response->body(), true);
    expect($data['props']['flash']['success'])->toBe('Saved!');
    expect($data['props']['user']['name'])->toBe('Test');
});
