<?php

declare(strict_types=1);

namespace App\ReactWeb\Controller;

use Marko\Inertia\Inertia;
use Marko\Inertia\Middleware\InertiaMiddleware;
use Marko\Routing\Attributes\Get;
use Marko\Routing\Attributes\Middleware;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;

#[Middleware([InertiaMiddleware::class])]
class ReactDemoController
{
    public function __construct(
        private Inertia $inertia,
    ) {}

    #[Get('/react')]
    public function index(Request $request): Response
    {
        return $this->inertia->render(
            request: $request,
            component: 'ReactHome',
            props: [
                'framework' => 'React',
                'accent' => 'blue',
                'features' => [
                    'React 19 client entry',
                    'Inertia Link and Head components',
                    'Marko route attributes',
                    'Shared Tailwind CSS build',
                ],
            ],
            assetEntry: 'app/react-web/resources/js/app.jsx',
        );
    }
}
