<?php

declare(strict_types=1);

namespace Marko\Inertia;

use JsonException;
use Marko\Config\ConfigRepositoryInterface;
use Marko\Inertia\Ssr\SsrClient;
use Marko\Routing\Http\Request;
use Marko\Routing\Http\Response;
use Marko\Vite\Vite;

class Inertia
{
    /** @var array<string, mixed> */
    private array $shared = [];

    public function __construct(
        private readonly ConfigRepositoryInterface $config,
        private readonly Vite $vite,
        private readonly SsrClient $ssrClient,
    ) {}

    /**
     * Share data across all Inertia responses.
     *
     * @param array<string, mixed>|string $key
     * @param mixed $value
     */
    public function share(array|string $key, mixed $value = null): void
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->shared[$k] = $v;
            }
            return;
        }

        $this->shared[$key] = $value;
    }

    /**
     * Render an Inertia page response.
     *
     * @param array<string, mixed> $props
     *
     * @throws JsonException
     */
    public function render(
        Request $request,
        string $component,
        array $props = [],
    ): Response {
        $page = [
            'component' => $component,
            'props' => array_merge($this->shared, $props),
            'url' => $request->path(),
            'version' => $this->version(),
        ];

        if ($this->isInertiaRequest($request)) {
            return new Response(
                body: json_encode($page, JSON_THROW_ON_ERROR),
                headers: [
                    'Content-Type' => 'application/json',
                    'Vary' => 'Accept',
                    'X-Inertia' => 'true',
                ],
            );
        }

        return $this->renderRootView($page);
    }

    /**
     * Create an Inertia location redirect (for external/non-Inertia URLs).
     */
    public function location(string $url): Response
    {
        return new Response(
            body: '',
            headers: [
                'X-Inertia-Location' => $url,
            ],
        );
    }

    /**
     * Check if the request is an Inertia request.
     */
    public function isInertiaRequest(Request $request): bool
    {
        return $request->header('X-Inertia') === 'true';
    }

    /**
     * Get the configured asset version.
     */
    public function version(): ?string
    {
        try {
            return $this->config->get('inertia.version');
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Render the root view with the Inertia page data embedded.
     *
     * @param array<string, mixed> $page
     *
     * @throws JsonException
     */
    private function renderRootView(array $page): Response
    {
        $pageJson = json_encode($page, JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
        $pageJson = htmlspecialchars($pageJson, ENT_QUOTES, 'UTF-8');

        $headTags = $this->vite->headTags();
        $ssr = $this->trySsr($page);

        $ssrHead = $ssr['head'] ?? '';
        $ssrBody = $ssr['body'] ?? null;

        if ($ssrBody !== null) {
            $bodyHtml = $ssrBody;
        } else {
            $bodyHtml = '<div id="app" data-page="' . $pageJson . '"></div>';
        }

        $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marko + Inertia</title>
    {$headTags}
    {$ssrHead}
</head>
<body>
    {$bodyHtml}
</body>
</html>
HTML;

        return Response::html($html);
    }

    /**
     * Try to render the page via SSR server. Returns null on failure
     * so client-side rendering can take over gracefully.
     *
     * @param array<string, mixed> $page
     *
     * @return array{head: string, body: string}|null
     */
    private function trySsr(array $page): ?array
    {
        try {
            $enabled = $this->config->getBool('inertia.ssr.enabled');
        } catch (\Throwable) {
            return null;
        }

        if (!$enabled) {
            return null;
        }

        return $this->ssrClient->render($page);
    }
}
