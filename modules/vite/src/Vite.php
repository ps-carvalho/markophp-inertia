<?php

declare(strict_types=1);

namespace Marko\Vite;

use Marko\Config\ConfigRepositoryInterface;
use Marko\Core\Path\ProjectPaths;

readonly class Vite
{
    public function __construct(
        private ConfigRepositoryInterface $config,
        private ProjectPaths $paths,
    ) {}

    /**
     * Generate Vite script/link tags for the HTML head.
     */
    public function headTags(string $entry = 'app/web/resources/js/app.js'): string
    {
        if ($this->useDevServer()) {
            return $this->devServerTags($entry);
        }

        return $this->manifestTags($entry);
    }

    /**
     * Check if Vite dev server should be used.
     */
    public function useDevServer(): bool
    {
        try {
            return $this->config->getBool('vite.useDevServer');
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Tags for Vite dev server (hot module replacement).
     */
    private function devServerTags(string $entry): string
    {
        $url = rtrim($this->config->getString('vite.devServerUrl'), '/');
        $tags = '';

        foreach ($this->devServerStylesheets() as $stylesheet) {
            $stylesheet = ltrim($stylesheet, '/');
            $tags .= "<link rel=\"stylesheet\" href=\"{$url}/{$stylesheet}\">\n";
        }

        if ($this->isReactEntry($entry)) {
            $tags .= $this->reactRefreshPreamble($url) . "\n";
        }

        $tags .= <<<HTML
<script type="module" src="{$url}/@vite/client"></script>
<script type="module" src="{$url}/{$entry}"></script>
HTML;

        return $tags;
    }

    /**
     * React Fast Refresh expects this preamble when Vite is not serving the
     * application HTML itself.
     */
    private function reactRefreshPreamble(string $url): string
    {
        return <<<HTML
<script type="module">
import { injectIntoGlobalHook } from "{$url}/@react-refresh";
injectIntoGlobalHook(window);
window.\$RefreshReg\$ = () => {};
window.\$RefreshSig\$ = () => (type) => type;
</script>
HTML;
    }

    private function isReactEntry(string $entry): bool
    {
        return str_ends_with($entry, '.jsx') || str_ends_with($entry, '.tsx');
    }

    /**
     * Stylesheets served directly by Vite in dev mode.
     *
     * @return list<string>
     */
    private function devServerStylesheets(): array
    {
        try {
            $stylesheets = $this->config->getArray('vite.devServerStylesheets');
        } catch (\Throwable) {
            return [];
        }

        return array_values(array_filter(
            $stylesheets,
            static fn (mixed $stylesheet): bool => is_string($stylesheet) && $stylesheet !== '',
        ));
    }

    /**
     * Tags from production build manifest.
     */
    private function manifestTags(string $entry): string
    {
        $manifestPath = $this->manifestPath();

        if (!is_file($manifestPath)) {
            return '<!-- Vite manifest not found. Run: npm run build -->';
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        if (!is_array($manifest)) {
            return '<!-- Vite manifest is invalid -->';
        }

        $buildDir = $this->config->getString('vite.buildDirectory');
        $basePath = '/' . trim($buildDir, '/') . '/';

        $entryData = $manifest[$entry] ?? null;
        if ($entryData === null) {
            return "<!-- Vite entry '{$entry}' not found in manifest -->";
        }

        $tags = '';

        if (isset($entryData['css']) && is_array($entryData['css'])) {
            foreach ($entryData['css'] as $css) {
                $tags .= "<link rel=\"stylesheet\" href=\"{$basePath}{$css}\">\n    ";
            }
        }

        $tags .= "<script type=\"module\" src=\"{$basePath}{$entryData['file']}\"></script>";

        return $tags;
    }

    /**
     * Resolve the absolute path to the Vite manifest file.
     */
    private function manifestPath(): string
    {
        $buildDir = $this->config->getString('vite.buildDirectory');
        $manifestFilename = $this->config->getString('vite.manifestFilename');

        return $this->paths->base . '/public/' . trim($buildDir, '/') . '/' . $manifestFilename;
    }
}
