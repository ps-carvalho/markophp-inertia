<?php

declare(strict_types=1);

use Marko\Config\ConfigRepositoryInterface;
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
            $config = $container->get(ConfigRepositoryInterface::class);
            if (! $config instanceof ConfigRepositoryInterface) {
                throw new RuntimeException('Config repository binding must implement '.ConfigRepositoryInterface::class);
            }

            $url = 'http://localhost:13714';

            try {
                $url = $config->getString('inertia.ssr.url');
            } catch (Throwable) {
                // Use default
            }

            return new SsrClient($url);
        },
        Inertia::class => function (ContainerInterface $container): Inertia {
            $config = $container->get(ConfigRepositoryInterface::class);
            $vite = $container->get(Vite::class);
            $ssrClient = $container->get(SsrClient::class);

            if (! $config instanceof ConfigRepositoryInterface) {
                throw new RuntimeException('Config repository binding must implement '.ConfigRepositoryInterface::class);
            }

            if (! $vite instanceof Vite) {
                throw new RuntimeException('Vite binding must resolve to '.Vite::class);
            }

            if (! $ssrClient instanceof SsrClient) {
                throw new RuntimeException('SSR client binding must resolve to '.SsrClient::class);
            }

            return new Inertia(
                $config,
                $vite,
                $ssrClient,
            );
        },
    ],
    'singletons' => [
        Inertia::class,
        SsrClient::class,
    ],
];
