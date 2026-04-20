<?php

declare(strict_types=1);

use App\Web\Controller\AuthController;
use Marko\Routing\Http\Request;

test('login redirects to dashboard with valid credentials', function () {
    $auth = new FakeAuthManager(attemptResult: true);
    $controller = new AuthController($auth);

    $response = $controller->login(new Request(post: [
        'email' => 'demo@example.com',
        'password' => 'password',
    ]));

    expect($auth->attemptedCredentials)->toBe([
        'email' => 'demo@example.com',
        'password' => 'password',
    ]);
    expect($response->statusCode())->toBe(302);
    expect($response->headers()['Location'])->toBe('/dashboard');
});

test('login accepts json credentials and returns validation errors', function () {
    $auth = new FakeAuthManager(attemptResult: false);
    $controller = new AuthController($auth);

    $response = $controller->login(new Request(
        body: json_encode([
            'email' => 'bad@example.com',
            'password' => 'wrong',
        ], JSON_THROW_ON_ERROR),
    ));

    expect($auth->attemptedCredentials)->toBe([
        'email' => 'bad@example.com',
        'password' => 'wrong',
    ]);
    expect($response->statusCode())->toBe(422);
    expect($response->headers()['Content-Type'])->toBe('application/json');
    expect(json_decode($response->body(), true))->toHaveKey('errors');
});

test('logout clears the auth session and redirects home', function () {
    $auth = new FakeAuthManager();
    $controller = new AuthController($auth);

    $response = $controller->logout();

    expect($auth->loggedOut)->toBeTrue();
    expect($response->statusCode())->toBe(302);
    expect($response->headers()['Location'])->toBe('/');
});
