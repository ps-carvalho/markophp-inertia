<?php

declare(strict_types=1);

use Marko\Config\ConfigRepository;
use Marko\Core\Path\ProjectPaths;
use Marko\Vite\Vite;

beforeEach(function () {
    $this->basePath = dirname(__DIR__, 4);
    $this->paths = new ProjectPaths($this->basePath);
});

test('vite returns manifest not found when manifest is missing', function () {
    $config = new ConfigRepository([
        'vite' => [
            'buildDirectory' => 'build',
            'manifestFilename' => '.vite/nonexistent.json',
            'useDevServer' => false,
        ],
    ]);

    $vite = new Vite($config, $this->paths);
    $tags = $vite->headTags();

    expect($tags)->toContain('Vite manifest not found');
});

test('vite detects dev server from config', function () {
    $config = new ConfigRepository([
        'vite' => [
            'devServerUrl' => 'http://localhost:5173',
            'useDevServer' => true,
        ],
    ]);

    $vite = new Vite($config, $this->paths);

    expect($vite->useDevServer())->toBeTrue();
});

test('vite dev server tags include vite client and entry', function () {
    $config = new ConfigRepository([
        'vite' => [
            'devServerUrl' => 'http://localhost:5173',
            'devServerStylesheets' => [
                'app/web/resources/css/app.css',
            ],
            'useDevServer' => true,
        ],
    ]);

    $vite = new Vite($config, $this->paths);
    $tags = $vite->headTags('app/web/resources/js/app.js');

    expect($tags)->toContain('@vite/client');
    expect($tags)->toContain('app/web/resources/js/app.js');
    expect($tags)->toContain('rel="stylesheet"');
    expect($tags)->toContain('app/web/resources/css/app.css');
    expect($tags)->not->toContain('@react-refresh');
});

test('vite dev server tags use the configured dev server url', function () {
    $config = new ConfigRepository([
        'vite' => [
            'devServerUrl' => 'http://localhost:5174',
            'devServerStylesheets' => [],
            'useDevServer' => true,
        ],
    ]);

    $vite = new Vite($config, $this->paths);
    $tags = $vite->headTags('app/react-web/resources/js/app.jsx');

    expect($tags)->toContain('http://localhost:5174/@vite/client');
    expect($tags)->toContain('http://localhost:5174/app/react-web/resources/js/app.jsx');
    expect($tags)->toContain('http://localhost:5174/@react-refresh');
    expect($tags)->toContain('window.$RefreshReg$');
    expect($tags)->not->toContain('localhost:5173');
});

test('vite dev server tags skip react refresh preamble for svelte entries', function () {
    $config = new ConfigRepository([
        'vite' => [
            'devServerUrl' => 'http://localhost:5173',
            'devServerStylesheets' => [],
            'useDevServer' => true,
        ],
    ]);

    $vite = new Vite($config, $this->paths);
    $tags = $vite->headTags('app/svelte-web/resources/js/app.js');

    expect($tags)->toContain('app/svelte-web/resources/js/app.js');
    expect($tags)->not->toContain('@react-refresh');
    expect($tags)->not->toContain('window.$RefreshReg$');
});
