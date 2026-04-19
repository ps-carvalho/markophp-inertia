<?php

declare(strict_types=1);

return [
    // Vue-specific Inertia defaults.
    // The SSR bundle path for Vue apps.
    'ssrBundle' => env('INERTIA_VUE_SSR_BUNDLE', __DIR__ . '/../../../../bootstrap/ssr/ssr.js'),
];
