<?php

declare(strict_types=1);

use Marko\Core\Container\ContainerInterface;
use Marko\Inertia\Inertia;
use Marko\Inertia\Ssr\SsrClient;
use Marko\Vite\Vite;

return [
    'enabled' => true,
    'sequence' => [
        'after' => ['marko/config', 'marko/routing', 'marko/vite'],
    ],
    'bindings' => [
        SsrClient::class => function (ContainerInterface $container): SsrClient {
            $config = $container->get(\Marko\Config\ConfigRepositoryInterface::class);
            $url = 'http://localhost:13714';

            try {
                $url = $config->getString('inertia.ssr.url');
            } catch (\Throwable) {
                // Use default
            }

            return new SsrClient($url);
        },
        Inertia::class => function (ContainerInterface $container): Inertia {
            return new Inertia(
                $container->get(\Marko\Config\ConfigRepositoryInterface::class),
                $container->get(Vite::class),
                $container->get(SsrClient::class),
            );
        },
    ],
    'singletons' => [
        Inertia::class,
        SsrClient::class,
    ],
];
