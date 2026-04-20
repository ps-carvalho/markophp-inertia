<?php

declare(strict_types=1);

namespace App\Web\Controller;

use Marko\Authentication\AuthManager;
use Marko\Authentication\Middleware\GuestMiddleware;
use Marko\Inertia\Inertia;
use Marko\Inertia\Middleware\InertiaMiddleware;
use Marko\Routing\Attributes\Get;
use Marko\Routing\Attributes\Middleware;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;

#[Middleware([InertiaMiddleware::class])]
class HomeController
{
    public function __construct(
        private Inertia $inertia,
        private AuthManager $auth,
    ) {}

    #[Get("/")]
    public function index(Request $request): Response
    {
        return $this->inertia->render($request, 'Landing');
    }

    #[Get("/login", middleware: [GuestMiddleware::class])]
    public function login(Request $request): Response
    {
        return $this->inertia->render($request, 'Login');
    }

    #[Get("/about")]
    public function about(): Response
    {
        return Response::json([
            'name' => 'Marko Skeleton',
            'description' => 'A modular PHP framework with attribute-based routing.',
        ]);
    }
}
