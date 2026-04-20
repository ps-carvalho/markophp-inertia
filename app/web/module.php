<?php

declare(strict_types=1);

use App\Web\Auth\InMemoryUserProvider;
use Marko\Authentication\Contracts\UserProviderInterface;

return [
    'enabled' => true,
    'sequence' => [
        'after' => [
            'marko/routing',
            'marko/session',
            'marko/session-file',
            'marko/authentication',
            'marko/inertia',
            'marko/inertia-vue',
        ],
    ],
    'bindings' => [
        UserProviderInterface::class => InMemoryUserProvider::class,
    ],
    'singletons' => [
        InMemoryUserProvider::class,
    ],
];
