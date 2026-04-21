# Marko Application Skeleton

> A modern, full-stack application skeleton for the [Marko Framework](https://marko.build) featuring **Inertia.js**, **Vue 3**, **React 19**, **Svelte 5**, **Tailwind CSS v4**, and **Vite**.

This skeleton provides a complete starting point for building single-page applications (SPAs) with a PHP backend and interchangeable Inertia frontend adapters, all within Marko's modular architecture.

---

## ✨ Features

- **🚀 Marko Framework** — A lightweight, modular PHP 8.5+ framework built for flexibility
- **⚡ Inertia.js** — Build SPAs without building an API. Server-side routing with client-side navigation
- **🎨 Vue 3, React 19, and Svelte 5 demos** — Three frontend adapters running from separate Marko modules
- **💨 Tailwind CSS v4** — Utility-first styling with Vite integration
- **🔥 Vite HMR** — Lightning-fast hot module replacement for development
- **🖥️ Server-Side Rendering** — Vue SSR server plus React/Svelte SSR build entries for adapter demos
- **📦 Modular Architecture** — Self-contained modules with auto-discovery (bindings, middleware, config, routes)
- **🧪 Pest PHP** — Modern, elegant testing framework included
- **🐳 Docker Ready** — Multi-stage Dockerfile and docker-compose for consistent development environments

---

## 📁 Project Structure

```
.
├── app/
│   ├── web/                  # Vue/Inertia module
│   │   ├── resources/
│   │   │   ├── js/
│   │   │   │   ├── app.js    # Client entry point
│   │   │   │   ├── ssr.js    # SSR server entry point
│   │   │   │   ├── layouts/  # Vue layouts (AppLayout.vue)
│   │   │   │   └── pages/    # Vue pages (Dashboard.vue, Profile.vue)
│   │   │   └── css/
│   │   │       └── app.css   # Tailwind entry
│   │   └── src/Controller/
│   ├── react-web/            # React/Inertia demo module
│   │   ├── resources/js/     # app.jsx, ssr.jsx, React pages
│   │   └── src/Controller/
│   ├── svelte-web/           # Svelte/Inertia demo module
│   │   ├── resources/js/     # app.js, ssr.js, Svelte pages
│   │   └── src/Controller/
│   └── foo/                  # Example plain Marko module
│
├── modules/                  # Optional local Marko modules
│
├── packages/                 # Ignored local path repository packages used during development
│   ├── inertia/              # marko/inertia
│   ├── inertia-vue/          # marko/inertia-vue
│   ├── inertia-react/        # marko/inertia-react
│   ├── inertia-svelte/       # marko/inertia-svelte
│   └── vite/                 # marko/vite
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

If port `5173` is already in use, change both Vite values in `.env` before starting the servers:

```bash
VITE_DEV_SERVER_URL=http://localhost:5174
VITE_DEV_SERVER_PORT=5174
```

Then restart `composer dev` so PHP emits tags for the same Vite server URL that Vite is actually using.

Visit one of the demo routes:

| Route | Adapter | Module |
|-------|---------|--------|
| `/` | Vue 3 | `app/web` |
| `/dashboard` | Vue 3 | `app/web` |
| `/react` | React 19 | `app/react-web` |
| `/svelte` | Svelte 5 | `app/svelte-web` |

#### Available Commands

| Command | Description |
|---------|-------------|
| `composer dev` | Run PHP + Vite + SSR concurrently |
| `npm run dev` | Run Vite dev server only |
| `npm run build` | Build production assets |
| `npm run build:ssr` | Build Vue, React, and Svelte SSR bundles |
| `npm run build:ssr:vue` | Build the Vue SSR server bundle |
| `npm run build:ssr:react` | Build the React SSR entry bundle |
| `npm run build:ssr:svelte` | Build the Svelte SSR entry bundle |
| `composer build` | Build both client and SSR assets |
| `vendor/bin/pest` | Run the full test suite |

### Docker Development

If you prefer Docker, the included multi-stage Dockerfile and `docker-compose.yml` provide a ready-to-use development environment:

```bash
docker compose up --build
```

Ports exposed:
- `8000` — PHP application
- `5174` — Vite HMR server on the host, mapped to `5173` inside the container

The Docker configuration sets `VITE_DEV_SERVER_URL=http://localhost:5174` for you, so browser-loaded Vite assets point at the host port that is actually published.

The container uses named volumes for `node_modules`, `vendor`, `bootstrap/ssr`, and `public/build` to avoid conflicts between host and container filesystems.

The local `packages/` directory is ignored by the main app repository but is still part of the Docker build context. Docker copies it before `composer install` so Composer can resolve the Marko path repository packages.

If Docker reports a missing JavaScript package after dependencies change, refresh the named volumes:

```bash
docker compose down -v
docker compose up --build
```

---

## 🏗️ Architecture

### Inertia.js Integration

The project includes custom Inertia.js packages built specifically for Marko. In this workspace they live in `packages/` and are installed into the application through Composer path repositories. The directory is ignored by the main app repository so those packages can be versioned separately.

- **`marko/inertia`** — Core protocol implementation:
  - `Inertia` response factory with shared data and lazy prop evaluation
  - `InertiaMiddleware` — handles `X-Inertia` headers, `Vary: Accept`, and asset version mismatch responses
  - `SsrClient` — POSTs render requests to the Node.js SSR server
  - Flash message support

- **`marko/inertia-vue`** — Vue 3 companion package with configuration for root views, Vite, and SSR settings

- **`marko/inertia-react`** — React companion package with client and SSR entry configuration

- **`marko/inertia-svelte`** — Svelte companion package with client and SSR entry configuration

- **`marko/vite`** — Standalone Vite integration for asset manifest resolution and dev-server tag injection

Require only the adapter packages your app uses. Each adapter pulls in `marko/inertia` and `marko/vite` transitively:

```bash
composer require marko/inertia-vue
composer require marko/inertia-react
composer require marko/inertia-svelte
```

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

Each frontend module auto-discovers pages for its own adapter using Vite glob imports:

```javascript
// app/web/resources/js/app.js
const pages = import.meta.glob([
  '/app/**/resources/js/pages/**/*.vue',
  '/modules/**/resources/js/pages/**/*.vue',
], { eager: true });
```

This means you can add pages anywhere in `app/` or `modules/` and they will be automatically available to Inertia.

React and Svelte use the same pattern with framework-specific extensions:

- React pages: `app/**/resources/js/pages/**/*.{jsx,tsx}`
- Svelte pages: `app/**/resources/js/pages/**/*.svelte`

### Adding Another Frontend Demo

The React and Svelte demos show the pattern for adding an alternate Inertia adapter:

1. Create a Marko module under `app/`, for example `app/react-web`.
2. Add a controller that calls `$this->inertia->render(..., assetEntry: 'app/react-web/resources/js/app.jsx')`.
3. Add a Vite entry file that calls the adapter's `createInertiaApp`.
4. Register the entry in `vite.config.js` under `build.rollupOptions.input`.
5. Add or require a companion Marko package if the adapter needs shared config.

---

## 🧪 Testing

Tests are written with [Pest PHP](https://pestphp.com/):

```bash
# Run all tests
vendor/bin/pest

# Run tests for a specific package in this workspace
vendor/bin/pest packages/vite/tests
vendor/bin/pest packages/inertia/tests
vendor/bin/pest packages/inertia-vue/tests
vendor/bin/pest packages/inertia-react/tests
vendor/bin/pest packages/inertia-svelte/tests
```

---

## 📖 Demo Pages

The skeleton ships with multiple example pages to demonstrate the stack:

- **Dashboard** (`/dashboard`) — Stats cards, SVG chart, activity feed, and flash messages
- **Profile** (`/profile`) — User profile with gradient header, avatar, and account details
- **React Demo** (`/react`) — Independent React/Inertia Marko module and Vite entry
- **Svelte Demo** (`/svelte`) — Independent Svelte/Inertia Marko module and Vite entry

The Vue pages use `AppLayout.vue` as a shared layout with sidebar navigation and demonstrate Inertia `<Link>` SPA navigation and `<Head>` title management. React and Svelte are intentionally separate modules so you can inspect each adapter without mixing component systems.

---

## 🤝 Contributing

Contributions are welcome and appreciated! Whether it's bug reports, feature requests, documentation improvements, or code contributions — we'd love your help.

### How to Contribute

1. **Fork** the repository and create your branch from `main`
2. **Set up** the project locally using the instructions above
3. **Make your changes** — whether fixing a bug or adding a feature
4. **Write tests** — ensure your changes are covered by Pest tests
5. **Run the test suite** — `vendor/bin/pest`
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
- [React Documentation](https://react.dev/)
- [Svelte Documentation](https://svelte.dev/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [Vite Documentation](https://vitejs.dev/)
