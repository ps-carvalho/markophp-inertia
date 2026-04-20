<?php

declare(strict_types=1);

use Marko\Config\ConfigRepository;
use Marko\Inertia\Middleware\InertiaMiddleware;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;

beforeEach(function () {
    $this->config = new ConfigRepository([
        'inertia' => [
            'version' => '1.0',
        ],
    ]);
    $this->middleware = new InertiaMiddleware($this->config);
});

test('middleware passes through non-inertia requests unchanged', function () {
    $request = new Request();
    $originalResponse = new Response(body: 'OK');

    $response = $this->middleware->handle($request, fn () => $originalResponse);

    expect($response->body())->toBe('OK');
    expect($response->headers())->not->toHaveKey('X-Inertia');
});

test('middleware adds inertia headers for inertia requests', function () {
    $request = new Request(server: ['HTTP_X_INERTIA' => 'true']);
    $originalResponse = new Response(body: '{}', headers: ['Content-Type' => 'application/json']);

    $response = $this->middleware->handle($request, fn () => $originalResponse);

    expect($response->headers()['X-Inertia'])->toBe('true');
    expect($response->headers()['Vary'])->toBe('Accept');
});

test('middleware leaves redirects unchanged for inertia requests', function () {
    $request = new Request(server: ['HTTP_X_INERTIA' => 'true']);
    $originalResponse = Response::redirect('/other');

    $response = $this->middleware->handle($request, fn () => $originalResponse);

    expect($response->statusCode())->toBe(302);
    expect($response->headers()['Location'])->toBe('/other');
    expect($response->headers())->not->toHaveKey('X-Inertia-Location');
});

test('middleware returns 409 on version mismatch', function () {
    $request = new Request(server: [
        'HTTP_X_INERTIA' => 'true',
        'HTTP_X_INERTIA_VERSION' => '0.9',
    ]);
    $originalResponse = new Response(body: '{}');

    $response = $this->middleware->handle($request, fn () => $originalResponse);

    expect($response->statusCode())->toBe(409);
    expect($response->headers()['X-Inertia-Location'])->toBe('/');
});
