#!/usr/bin/env sh
set -eu

composer install --no-interaction
npm ci
npm run build:ssr

exec composer dev
