<?php

declare(strict_types=1);

namespace App\Web\Controller;

use Marko\Authentication\AuthManager;
use Marko\Routing\Attributes\Post;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;
use JsonException;

class AuthController
{
    public function __construct(
        private AuthManager $auth,
    ) {}

    #[Post("/login")]
    public function login(Request $request): Response
    {
        $credentials = [
            'email' => $this->input($request, 'email'),
            'password' => $this->input($request, 'password'),
        ];

        if ($this->auth->attempt($credentials)) {
            return Response::redirect('/dashboard');
        }

        return Response::json([
            'errors' => ['message' => 'Invalid credentials. Try demo@example.com / password'],
        ], 422);
    }

    #[Post("/logout")]
    public function logout(): Response
    {
        $this->auth->logout();

        return Response::redirect('/');
    }

    private function input(Request $request, string $key): mixed
    {
        $value = $request->post($key);

        if ($value !== null) {
            return $value;
        }

        try {
            $payload = json_decode($request->body(), true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return null;
        }

        return is_array($payload) ? ($payload[$key] ?? null) : null;
    }
}
