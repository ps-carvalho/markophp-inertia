<?php

declare(strict_types=1);

namespace Marko\Inertia\Middleware;

use Marko\Config\ConfigRepositoryInterface;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;
use Marko\Routing\Middleware\MiddlewareInterface;

readonly class InertiaMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ConfigRepositoryInterface $config,
    ) {}

    public function handle(Request $request, callable $next): Response
    {
        $response = $next($request);

        if (!$this->isInertiaRequest($request)) {
            return $response;
        }

        $headers = $response->headers();
        $headers['Vary'] = 'Accept';
        $headers['X-Inertia'] = 'true';

        // Check asset version mismatch (only when client sends a version)
        try {
            $version = $this->config->get('inertia.version');
        } catch (\Throwable) {
            $version = null;
        }

        $requestVersion = $request->header('X-Inertia-Version');
        if ($version !== null && $requestVersion !== null && $requestVersion !== (string) $version) {
            return new Response(
                body: '',
                statusCode: 409,
                headers: array_merge($headers, [
                    'X-Inertia-Location' => $request->path(),
                ]),
            );
        }

        // Convert 302/301 redirects to 409 Conflict for Inertia requests
        if (in_array($response->statusCode(), [301, 302], true)) {
            $location = $response->headers()['Location'] ?? null;

            if ($location !== null) {
                return new Response(
                    body: '',
                    statusCode: 409,
                    headers: array_merge($headers, [
                        'X-Inertia-Location' => $location,
                    ]),
                );
            }
        }

        return new Response(
            body: $response->body(),
            statusCode: $response->statusCode(),
            headers: $headers,
        );
    }

    private function isInertiaRequest(Request $request): bool
    {
        return $request->header('X-Inertia') === 'true';
    }
}
