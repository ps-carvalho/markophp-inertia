<?php

declare(strict_types=1);

namespace Marko\Inertia\Ssr;

use JsonException;

readonly class SsrClient
{
    public function __construct(
        private string $url,
    ) {}

    /**
     * Render a page via the Inertia SSR server.
     *
     * @param array<string, mixed> $page
     *
     * @return array{head: string, body: string}|null
     */
    public function render(array $page): ?array
    {
        $json = json_encode($page, JSON_THROW_ON_ERROR);

        $response = $this->post($json);

        if ($response === null) {
            return null;
        }

        $data = json_decode($response, true);

        if (!is_array($data) || isset($data['error'])) {
            return null;
        }

        return [
            'head' => $data['head'] ?? '',
            'body' => $data['body'] ?? '',
        ];
    }

    private function post(string $body): ?string
    {
        $ch = curl_init($this->url);

        if ($ch === false) {
            return null;
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);

        $response = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false || $httpCode !== 200) {
            return null;
        }

        return (string) $response;
    }
}
