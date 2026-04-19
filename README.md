# Marko Application Skeleton

> A modern, full-stack application skeleton for the [Marko Framework](https://marko.build) featuring **Inertia.js**, **Vue 3**, **Tailwind CSS v4**, and **Vite** — with first-class **SSR** support.

This skeleton provides a complete starting point for building single-page applications (SPAs) with a PHP backend and a Vue frontend, all within Marko's modular architecture.

---

## ✨ Features

- **🚀 Marko Framework** — A lightweight, modular PHP 8.5+ framework built for flexibility
- **⚡ Inertia.js** — Build SPAs without building an API. Server-side routing with client-side navigation
- **🎨 Vue 3** — Reactive frontend with Composition API support
- **💨 Tailwind CSS v4** — Utility-first styling with Vite integration
- **🔥 Vite HMR** — Lightning-fast hot module replacement for development
- **🖥️ Server-Side Rendering** — Vue SSR support via a Node.js render server for better SEO and performance
- **📦 Modular Architecture** — Self-contained modules with auto-discovery (bindings, middleware, config, routes)
- **🧪 Pest PHP** — Modern, elegant testing framework included
- **🐳 Docker Ready** — Multi-stage Dockerfile and docker-compose for consistent development environments

---

## 📁 Project Structure

```
.
├── app/
│   ├── web/                  # Website module (controllers, Vue pages, layouts)
│   │   ├── resources/
│   │   │   ├── js/
│   │   │   │   ├── app.js    # Client entry point
│   │   │   │   ├── ssr.js    # SSR server entry point
│   │   │   │   ├── layouts/  # Vue layouts (AppLayout.vue)
│   │   │   │   └── pages/    # Vue pages (Dashboard.vue, Profile.vue)
│   │   │   └── css/
│   │   │       └── app.css   # Tailwind entry
│   │   └── src/Controller/
│   └── foo/                  # Example plain Marko module
│
├── modules/
│   ├── inertia/              # Core Inertia.js adapter (middleware, shared data, lazy props, SSR client)
│   ├── inertia-vue/          # Vue-specific Inertia companion package
│   └── vite/                 # Vite integration (manifest resolution, dev-server detection)
│
├── config/                   # Root configuration
├── storage/                  # Logs, cache, sessions
├── public/                   # Web root
│   └── index.php             # Application entry point
├── bootstrap/ssr/            # SSR build output
├── Dockerfile                # Multi-stage build (dev & production targets)
├── docker-compose.yml        # Development orchestration
└── composer.json
```

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.5+
- Composer
- Node.js 22+ and npm
- (Optional) Docker & Docker Compose

### Installation

```bash
composer create-project marko/skeleton my-app
cd my-app
```

Copy the environment file:

```bash
cp .env.example .env
```

### Local Development

Install PHP and JavaScript dependencies:

```bash
composer install
npm install
```

Start all development servers (PHP, Vite HMR, and SSR) concurrently:

```bash
composer dev
```

This will start:
- **PHP** development server on `http://localhost:8000`
- **Vite** HMR server on `http://localhost:5173`
- **SSR** rendering server on `http://localhost:13714` (internal)

Visit [http://localhost:8000/dashboard](http://localhost:8000/dashboard) to see the demo application.

#### Available Commands

| Command | Description |
|---------|-------------|
| `composer dev` | Run PHP + Vite + SSR concurrently |
| `npm run dev` | Run Vite dev server only |
| `npm run build` | Build production assets |
| `npm run build:ssr` | Build SSR bundle |
| `composer build` | Build both client and SSR assets |
| `vendor/bin/pest modules/*/tests` | Run the test suite |

### Docker Development

If you prefer Docker, the included multi-stage Dockerfile and `docker-compose.yml` provide a ready-to-use development environment:

```bash
docker compose up --build
```

Ports exposed:
- `8000` — PHP application
- `5173` — Vite HMR server

The container uses named volumes for `node_modules`, `vendor`, `bootstrap/ssr`, and `public/build` to avoid conflicts between host and container filesystems.

---

## 🏗️ Architecture

### Inertia.js Integration

The project includes a custom Inertia.js adapter built specifically for Marko:

- **`modules/inertia`** — Core protocol implementation:
  - `Inertia` response factory with shared data and lazy prop evaluation
  - `InertiaMiddleware` — handles `X-Inertia` headers, 302 → 409 redirects, version mismatch
  - `SsrClient` — POSTs render requests to the Node.js SSR server
  - Flash message support

- **`modules/inertia-vue`** — Vue 3 companion package with configuration for root views, Vite, and SSR settings

- **`modules/vite`** — Standalone Vite integration for asset manifest resolution and dev-server tag injection

### Module System

Marko uses a powerful module system where each module is self-contained:

```php
// app/web/module.php
return [
    'bindings' => [
        // Dependency injection bindings
    ],
    'singletons' => [
        // Singleton services
    ],
    'middleware' => [
        // Route middleware
    ],
    'after' => [
        // Module load order dependencies
    ],
];
```

### Page Auto-Discovery

Vue pages are auto-discovered from all modules using Vite's glob imports:

```javascript
// app/web/resources/js/app.js
const pages = import.meta.glob([
  '/app/**/resources/js/pages/**/*.vue',
  '/modules/**/resources/js/pages/**/*.vue',
], { eager: true });
```

This means you can add pages anywhere in `app/` or `modules/` and they will be automatically available to Inertia.

---

## 🧪 Testing

Tests are written with [Pest PHP](https://pestphp.com/):

```bash
# Run all module tests
vendor/bin/pest modules/*/tests

# Run tests for a specific module
vendor/bin/pest modules/vite/tests
vendor/bin/pest modules/inertia/tests
vendor/bin/pest modules/inertia-vue/tests
```

---

## 📖 Demo Pages

The skeleton ships with two example pages to demonstrate the stack:

- **Dashboard** (`/dashboard`) — Stats cards, SVG chart, activity feed, and flash messages
- **Profile** (`/profile`) — User profile with gradient header, avatar, and account details

Both pages use `AppLayout.vue` as a shared layout with sidebar navigation and demonstrate Inertia `<Link>` SPA navigation and `<Head>` title management.

---

## 🤝 Contributing

Contributions are welcome and appreciated! Whether it's bug reports, feature requests, documentation improvements, or code contributions — we'd love your help.

### How to Contribute

1. **Fork** the repository and create your branch from `main`
2. **Set up** the project locally using the instructions above
3. **Make your changes** — whether fixing a bug or adding a feature
4. **Write tests** — ensure your changes are covered by Pest tests
5. **Run the test suite** — `vendor/bin/pest modules/*/tests`
6. **Submit a pull request** with a clear description of your changes

### Development Guidelines

- Follow existing code style and patterns
- Keep modules self-contained and independent
- All packages should use existing Marko extension points (bindings, singletons, middleware, module sequences)
- Ensure backward compatibility when possible
- Document significant changes in your PR description

### Reporting Issues

Found a bug or have a suggestion? Please open an issue with:
- A clear description of the problem or feature request
- Steps to reproduce (for bugs)
- Your environment details (PHP version, OS, etc.)

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## 🔗 Resources

- [Marko Framework Documentation](https://marko.build/docs/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Vue 3 Documentation](https://vuejs.org/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [Vite Documentation](https://vitejs.dev/)
