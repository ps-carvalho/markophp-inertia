<?php

declare(strict_types=1);

namespace App\Foo\Controller;

use Marko\Routing\Attributes\Get;
use Marko\Routing\Http\Response;

class GreetingController
{
    #[Get("/hello/{name}")]
    public function greet(string $name): Response
    {
        return new Response(body: "Hello, {$name}! Welcome to Marko.");
    }
}
