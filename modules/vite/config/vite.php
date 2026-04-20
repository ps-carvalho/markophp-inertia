<?php

declare(strict_types=1);

return [
    'buildDirectory' => 'build',
    'manifestFilename' => '.vite/manifest.json',
    'devServerUrl' => 'http://localhost:5173',
    'devServerStylesheets' => [
        'app/web/resources/css/app.css',
    ],
    'useDevServer' => env('APP_ENV', 'local') === 'local',
];
