<?php

declare(strict_types=1);

use App\Web\Auth\InMemoryUserProvider;

test('demo user can be retrieved by id and credentials', function () {
    $provider = new InMemoryUserProvider();

    $byId = $provider->retrieveById(1);
    $byCredentials = $provider->retrieveByCredentials([
        'email' => 'demo@example.com',
    ]);

    expect($byId)->not->toBeNull();
    expect($byCredentials)->toBe($byId);
    expect($byId->toArray())->toMatchArray([
        'id' => 1,
        'email' => 'demo@example.com',
        'name' => 'Marko User',
    ]);
});

test('demo user validates password credentials', function () {
    $provider = new InMemoryUserProvider();
    $user = $provider->retrieveByCredentials([
        'email' => 'demo@example.com',
    ]);

    expect($provider->validateCredentials($user, ['password' => 'password']))->toBeTrue();
    expect($provider->validateCredentials($user, ['password' => 'wrong']))->toBeFalse();
});

test('remember token is stored on the demo user', function () {
    $provider = new InMemoryUserProvider();
    $user = $provider->retrieveById(1);

    $provider->updateRememberToken($user, 'token-value');

    expect($user->getRememberToken())->toBe('token-value');
});
