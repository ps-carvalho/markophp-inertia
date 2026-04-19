<?php

declare(strict_types=1);

return [
    'buildDirectory' => 'build',
    'manifestFilename' => '.vite/manifest.json',
    'devServerUrl' => 'http://localhost:5173',
    'useDevServer' => env('APP_ENV', 'local') === 'local',
];
