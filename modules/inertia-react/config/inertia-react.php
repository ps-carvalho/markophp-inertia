<?php

declare(strict_types=1);

return [
    'clientEntry' => env('INERTIA_REACT_CLIENT_ENTRY', 'app/react-web/resources/js/app.jsx'),
    'ssrEntry' => env('INERTIA_REACT_SSR_ENTRY', 'app/react-web/resources/js/ssr.jsx'),
    'ssrBundle' => env('INERTIA_REACT_SSR_BUNDLE', __DIR__ . '/../../../../../bootstrap/ssr/react/ssr.js'),
];
