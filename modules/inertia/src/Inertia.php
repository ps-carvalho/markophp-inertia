<?php

declare(strict_types=1);

namespace Marko\Inertia;

use Closure;
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

    /** @var array<string, mixed> */
    private array $flash = [];

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
     * Flash a message to the session (stored for next request).
     *
     * In a real app this would use session storage. For now we store
     * in-memory which works for single-request demos.
     */
    public function flash(string $key, mixed $value = null): void
    {
        $this->flash[$key] = $value;
    }

    /**
     * Render an Inertia page response.
     *
     * Props can include closures (\Closure) for lazy evaluation.
     * Lazy props are only resolved when the prop is included in a
     * partial reload or on the initial full page load.
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
        $props = $this->resolveProps($props, $request, $component);

        $page = [
            'component' => $component,
            'props' => $props,
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
     * Resolve props, handling lazy evaluation and partial reloads.
     *
     * @param array<string, mixed> $props
     *
     * @return array<string, mixed>
     */
    private function resolveProps(array $props, Request $request, string $component): array
    {
        // Merge shared data (flash messages first, then shared data)
        $allProps = array_merge(
            ['flash' => $this->flash],
            $this->shared,
            $props,
        );

        // Clear flash after reading
        $this->flash = [];

        // Check if this is a partial reload request
        $partialComponent = $request->header('X-Inertia-Partial-Component');
        $partialData = $request->header('X-Inertia-Partial-Data');

        $isPartial = $partialComponent !== null
            && $partialComponent === $component
            && $partialData !== null;

        if ($isPartial) {
            $only = array_filter(explode(',', $partialData));
            // Always include shared/flash data and requested props
            $allProps = array_intersect_key($allProps, array_flip(array_merge(['flash'], $only)));
        }

        // Resolve closures (lazy evaluation)
        foreach ($allProps as $key => $value) {
            if ($value instanceof Closure) {
                $allProps[$key] = $value();
            }
        }

        return $allProps;
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
