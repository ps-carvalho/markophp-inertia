<?php

declare(strict_types=1);

namespace App\SvelteWeb\Controller;

use Marko\Inertia\Inertia;
use Marko\Inertia\Middleware\InertiaMiddleware;
use Marko\Routing\Attributes\Get;
use Marko\Routing\Attributes\Middleware;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;

#[Middleware([InertiaMiddleware::class])]
class SvelteDemoController
{
    public function __construct(
        private Inertia $inertia,
    ) {}

    #[Get('/svelte')]
    public function index(Request $request): Response
    {
        return $this->inertia->render(
            request: $request,
            component: 'SvelteHome',
            props: [
                'framework' => 'Svelte',
                'accent' => 'emerald',
                'features' => [
                    'Svelte 5 client entry',
                    'Inertia Link component',
                    'Marko route attributes',
                    'Shared Tailwind CSS build',
                ],
            ],
            assetEntry: 'app/svelte-web/resources/js/app.js',
        );
    }
}
