<?php

declare(strict_types=1);

return [
    'enabled' => true,
    'sequence' => [
        'after' => [
            'marko/routing',
            'marko/inertia',
            'marko/inertia-react',
        ],
    ],
];
