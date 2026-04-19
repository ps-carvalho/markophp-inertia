# syntax=docker/dockerfile:1

# Multi-stage Dockerfile for Marko application
# Supports both development (target=dev) and production (target=prod)

# ------------------------------------------------------------------
# Base stage: PHP 8.5 + system dependencies + Composer + Node.js
# ------------------------------------------------------------------
FROM php:8.5-cli AS base

WORKDIR /app

# Prevent interactive apt prompts
ENV DEBIAN_FRONTEND=noninteractive

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    ca-certificates \
    libcurl4-openssl-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    procps \
    && docker-php-ext-install curl mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer (latest stable)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js 22 (LTS) and npm
COPY --from=node:22-slim /usr/local/bin /usr/local/bin
COPY --from=node:22-slim /usr/local/lib /usr/local/lib
COPY --from=node:22-slim /usr/local/include /usr/local/include
COPY --from=node:22-slim /usr/local/share /usr/local/share

# Marko CLI is installed globally for convenience
RUN composer global require marko/cli --no-interaction
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# ------------------------------------------------------------------
# Development stage: install deps so named volumes start populated
# ------------------------------------------------------------------
FROM base AS dev

# Copy dependency manifests and install so named volumes are seeded
COPY composer.json composer.lock ./
RUN composer install --no-interaction

COPY package.json package-lock.json ./
RUN npm ci

# Copy source and build SSR bundle so the named volume is seeded
COPY . .
RUN npm run build:ssr

# Expose ports used in development
EXPOSE 8000 5173 13714

# Default command runs all dev services via composer
CMD ["composer", "dev"]

# ------------------------------------------------------------------
# Production stage: copy code, install deps, build assets
# ------------------------------------------------------------------
FROM base AS prod

# Copy dependency manifests first for layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --optimize-autoloader

COPY package.json package-lock.json ./
RUN npm ci

# Copy application source
COPY . .

# Build frontend assets and SSR bundle
RUN npm run build && npm run build:ssr

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public/"]
