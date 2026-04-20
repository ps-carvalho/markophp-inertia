<?php

declare(strict_types=1);

use App\ReactWeb\Controller\ReactDemoController;
use App\SvelteWeb\Controller\SvelteDemoController;
use Marko\Routing\Http\Request;

test('react demo returns react component props', function () {
    $controller = new ReactDemoController(createApplicationInertia());

    $response = $controller->index(new Request(server: [
        'HTTP_X_INERTIA' => 'true',
        'REQUEST_URI' => '/react',
    ]));

    $page = json_decode($response->body(), true);

    expect($page['component'])->toBe('ReactHome');
    expect($page['props']['framework'])->toBe('React');
    expect($page['props']['features'])->toContain('React 19 client entry');
});

test('react demo full page uses the react vite entry', function () {
    $controller = new ReactDemoController(createApplicationInertia());

    $response = $controller->index(new Request(server: [
        'REQUEST_URI' => '/react',
    ]));

    expect($response->body())->toContain('app/react-web/resources/js/app.jsx');
    expect($response->body())->not->toContain('app/web/resources/js/app.js');
});

test('svelte demo returns svelte component props', function () {
    $controller = new SvelteDemoController(createApplicationInertia());

    $response = $controller->index(new Request(server: [
        'HTTP_X_INERTIA' => 'true',
        'REQUEST_URI' => '/svelte',
    ]));

    $page = json_decode($response->body(), true);

    expect($page['component'])->toBe('SvelteHome');
    expect($page['props']['framework'])->toBe('Svelte');
    expect($page['props']['features'])->toContain('Svelte 5 client entry');
});

test('svelte demo full page uses the svelte vite entry', function () {
    $controller = new SvelteDemoController(createApplicationInertia());

    $response = $controller->index(new Request(server: [
        'REQUEST_URI' => '/svelte',
    ]));

    expect($response->body())->toContain('app/svelte-web/resources/js/app.js');
    expect($response->body())->not->toContain('app/web/resources/js/app.js');
});
