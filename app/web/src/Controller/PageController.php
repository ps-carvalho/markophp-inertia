<?php

declare(strict_types=1);

namespace App\Web\Controller;

use Marko\Inertia\Inertia;
use Marko\Inertia\Middleware\InertiaMiddleware;
use Marko\Routing\Attributes\Get;
use Marko\Routing\Attributes\Middleware;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;

#[Middleware([InertiaMiddleware::class])]
class PageController
{
    public function __construct(
        private Inertia $inertia,
    ) {}

    #[Get("/dashboard")]
    public function dashboard(Request $request): Response
    {
        return $this->inertia->render($request, 'Dashboard', [
            'user' => ['name' => 'Marko User', 'email' => 'user@example.com'],
            'chartData' => [45, 62, 38, 75, 52, 88, 67],
            'activities' => [
                ['title' => 'Deployed new version to production', 'time' => '2 hours ago'],
                ['title' => 'New user registration spike detected', 'time' => '4 hours ago'],
                ['title' => 'Database backup completed successfully', 'time' => '6 hours ago'],
                ['title' => 'API response time optimized by 24%', 'time' => '8 hours ago'],
                ['title' => 'Security patch applied to all nodes', 'time' => '12 hours ago'],
            ],
        ]);
    }

    #[Get("/profile")]
    public function profile(Request $request): Response
    {
        return $this->inertia->render($request, 'Profile', [
            'user' => ['name' => 'Marko User', 'email' => 'user@example.com'],
        ]);
    }
}
