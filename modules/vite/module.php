<?php

declare(strict_types=1);

use Marko\Core\Container\ContainerInterface;
use Marko\Core\Path\ProjectPaths;
use Marko\Vite\Vite;

return [
    'enabled' => true,
    'sequence' => [
        'after' => ['marko/config'],
    ],
    'bindings' => [
        Vite::class => function (ContainerInterface $container): Vite {
            return new Vite(
                $container->get(\Marko\Config\ConfigRepositoryInterface::class),
                $container->get(ProjectPaths::class),
            );
        },
    ],
    'singletons' => [
        Vite::class,
    ],
];
