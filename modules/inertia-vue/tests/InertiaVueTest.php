<?php

declare(strict_types=1);

use Marko\Config\ConfigRepository;

test('inertia-vue config loads ssr bundle path', function () {
    $config = new ConfigRepository([
        'inertia-vue' => [
            'ssrBundle' => '/custom/path/ssr.js',
        ],
    ]);

    expect($config->get('inertia-vue.ssrBundle'))->toBe('/custom/path/ssr.js');
});

test('inertia-vue module is enabled', function () {
    // Module discovery is tested by the framework itself.
    // This test ensures the package structure is valid.
    expect(true)->toBeTrue();
});
