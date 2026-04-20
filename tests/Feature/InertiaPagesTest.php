<?php

declare(strict_types=1);

use App\Web\Auth\InMemoryUserProvider;
use App\Web\Controller\HomeController;
use App\Web\Controller\PageController;
use Marko\Routing\Http\Request;

test('home page returns the landing inertia component', function () {
    $controller = new HomeController(
        createApplicationInertia(),
        new FakeAuthManager(),
    );

    $response = $controller->index(new Request(server: [
        'HTTP_X_INERTIA' => 'true',
        'REQUEST_URI' => '/',
    ]));

    $page = json_decode($response->body(), true);

    expect($response->headers()['X-Inertia'])->toBe('true');
    expect($page['component'])->toBe('Landing');
    expect($page['url'])->toBe('/');
});

test('dashboard page exposes authenticated user props', function () {
    $provider = new InMemoryUserProvider();
    $user = $provider->retrieveByCredentials(['email' => 'demo@example.com']);

    $controller = new PageController(
        createApplicationInertia(),
        new FakeAuthManager(fakeUser: $user),
    );

    $response = $controller->dashboard(new Request(server: [
        'HTTP_X_INERTIA' => 'true',
        'REQUEST_URI' => '/dashboard',
    ]));

    $page = json_decode($response->body(), true);

    expect($page['component'])->toBe('Dashboard');
    expect($page['props']['user'])->toMatchArray([
        'id' => 1,
        'name' => 'Marko User',
        'email' => 'demo@example.com',
    ]);
    expect($page['props']['chartData'])->toHaveCount(7);
    expect($page['props']['activities'])->toHaveCount(5);
});

test('profile page exposes authenticated user props', function () {
    $provider = new InMemoryUserProvider();
    $user = $provider->retrieveById(1);

    $controller = new PageController(
        createApplicationInertia(),
        new FakeAuthManager(fakeUser: $user),
    );

    $response = $controller->profile(new Request(server: [
        'HTTP_X_INERTIA' => 'true',
        'REQUEST_URI' => '/profile',
    ]));

    $page = json_decode($response->body(), true);

    expect($page['component'])->toBe('Profile');
    expect($page['props']['user']['role'])->toBe('Admin');
});
