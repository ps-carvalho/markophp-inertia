<?php

declare(strict_types=1);

namespace App\Web\Controller;

use Marko\Routing\Attributes\Get;
use Marko\Routing\Http\Response;

class HomeController
{
    #[Get("/")]
    public function index(): Response
    {
        return Response::html('<h1>Welcome to Marko</h1><p>Your website is running.</p>');
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
