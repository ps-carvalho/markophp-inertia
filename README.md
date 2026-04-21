# Marko Framework Ecosystem

> A comprehensive collection of PHP packages and application skeletons for building modern web applications with the Marko Framework, featuring seamless integration with Inertia.js, Vue 3, React 19, Svelte 5, Tailwind CSS v4, and Vite.

The Marko Framework Ecosystem provides a modular, flexible foundation for PHP developers to build single-page applications (SPAs) and full-stack web applications. This repository serves as the central hub, linking to all related projects, packages, and skeletons.

---

## 📦 Repositories

### Core Framework
- **[Marko Core Framework](https://github.com/marko-php/marko)** — The lightweight, modular PHP 8.5+ framework that powers the ecosystem. Provides dependency injection, routing, middleware, and module auto-discovery.

### Application Skeletons
Ready-to-use project templates for different frontend stacks:

- **[Marko Skeleton Inertia Vue](https://github.com/ps-carvalho/marko-skeleton-inertia-vue)** — Vue 3 + Inertia.js skeleton with Tailwind CSS and Vite integration.
- **[Marko Skeleton Inertia React](https://github.com/ps-carvalho/marko-skeleton-inertia-react)** — React 19 + Inertia.js skeleton with modern tooling.
- **[Marko Skeleton Inertia Svelte](https://github.com/ps-carvalho/marko-skeleton-inertia-svelte)** — Svelte 5 + Inertia.js skeleton for lightweight applications.

### Package Collection
- **[Marko Packages](https://github.com/ps-carvalho/marko-packages)** — Monorepo containing all Marko ecosystem packages, including Inertia adapters and Vite integration.

---

## 🛠️ Packages Overview

The Marko ecosystem is built around composable packages that can be mixed and matched based on your project needs. All packages are designed to work seamlessly with Marko's modular architecture.

### Core Packages

#### `marko/framework` (Core Framework)
The foundational package providing:
- **Dependency Injection Container** — PSR-11 compliant container with auto-wiring
- **Module System** — Self-contained modules with bindings, middleware, and configuration
- **Routing** — Attribute-based routing with middleware support
- **HTTP Abstractions** — Request/Response objects and middleware pipeline
- **Auto-Discovery** — Automatic registration of modules, routes, and services

#### `marko/vite`
Standalone Vite integration for Marko applications:
- **Asset Manifest Resolution** — Automatic resolution of built assets
- **Development Server Integration** — Hot module replacement (HMR) support
- **Tag Injection** — Automatic injection of CSS and JS tags in responses
- **Multi-Entry Support** — Handle multiple Vite entry points for different modules

### Inertia.js Integration Packages

#### `marko/inertia` (Core Inertia Protocol)
Implements the Inertia.js protocol for Marko:
- **Response Factory** — Create Inertia responses with shared data and lazy props
- **Middleware** — Handle `X-Inertia` headers, asset versioning, and partial reloads
- **SSR Client** — Communicate with Node.js SSR servers for server-side rendering
- **Flash Messages** — Built-in support for temporary session messages
- **Versioning** — Asset version mismatch detection and handling

#### `marko/inertia-vue`
Vue 3 companion package:
- **Vue 3 Integration** — Optimized for Vue 3 composition API
- **Root Component Setup** — Automatic setup of Inertia app root
- **SSR Configuration** — Server-side rendering support for Vue components
- **Vite Plugin Integration** — Seamless asset building and HMR

#### `marko/inertia-react`
React 19 companion package:
- **React 19 Support** — Latest React features including concurrent rendering
- **JSX Integration** — Full support for JSX and TSX components
- **SSR Ready** — Server-side rendering configuration
- **Hot Reloading** — Fast development with React Fast Refresh

#### `marko/inertia-svelte`
Svelte 5 companion package:
- **Svelte 5 Compatibility** — Supports latest Svelte features and runes
- **Component Auto-Discovery** — Automatic page component registration
- **SSR Implementation** — Server-side rendering for Svelte components
- **Minimal Bundle Size** — Optimized for Svelte's small footprint

---

## 🚀 Installation & Usage

### Installing the Core Framework

To start a new Marko project, use Composer to create from one of the skeletons:

```bash
# Vue 3 skeleton
composer create-project marko/skeleton-inertia-vue my-vue-app

# React 19 skeleton
composer create-project marko/skeleton-inertia-react my-react-app

# Svelte 5 skeleton
composer create-project marko/skeleton-inertia-svelte my-svelte-app
```

### Adding Packages to Existing Projects

Install individual packages as needed:

```bash
# Core framework (usually included in skeletons)
composer require marko/framework

# Vite integration
composer require marko/vite

# Inertia.js core
composer require marko/inertia

# Frontend adapters (choose one or more)
composer require marko/inertia-vue
composer require marko/inertia-react
composer require marko/inertia-svelte
```

### Development Setup

Each skeleton includes Docker support and local development tools:

```bash
cd my-app
composer install
npm install
composer dev  # Starts PHP server, Vite HMR, and SSR
```

Visit `http://localhost:8000` to see your application running.

### Docker Development

All skeletons support Docker for consistent environments:

```bash
docker compose up --build
```

---

## 🤝 Contributing

We welcome contributions from the community! The Marko ecosystem thrives on collaboration, whether you're fixing bugs, adding features, improving documentation, or sharing ideas.

### Ways to Contribute

- **🐛 Bug Reports** — Found an issue? Open a detailed bug report
- **💡 Feature Requests** — Have an idea? Share it in our discussions
- **📖 Documentation** — Help improve guides, tutorials, and API docs
- **🔧 Code Contributions** — Submit pull requests for fixes and features
- **🧪 Testing** — Write tests or help with test coverage
- **📣 Community Support** — Help others in discussions and issues

### Getting Started with Contributions

1. **Explore the Repositories** — Check out the links above to find the project that interests you
2. **Read the Contributing Guidelines** — Each repository has detailed contribution guidelines
3. **Join the Discussion** — Use GitHub Discussions for questions and ideas
4. **Fork and Clone** — Fork the repository and set up your development environment
5. **Make Your Changes** — Follow the coding standards and write tests
6. **Submit a PR** — Create a pull request with a clear description

### Development Philosophy

- **Modularity** — Keep packages focused and composable
- **Backward Compatibility** — Avoid breaking changes when possible
- **Testing** — Comprehensive test coverage for reliability
- **Documentation** — Clear, up-to-date documentation for all features
- **Community First** — Decisions are made with the community in mind

### Recognition

Contributors are recognized in repository READMEs and release notes. Significant contributions may lead to maintainer status or other acknowledgments.

---

## 📄 License

All Marko ecosystem projects are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🔗 Resources

- [Marko Framework Documentation](https://marko.build/docs/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Vue 3 Documentation](https://vuejs.org/)
- [React Documentation](https://react.dev/)
- [Svelte Documentation](https://svelte.dev/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [Vite Documentation](https://vitejs.dev/)
- [Pest PHP Testing](https://pestphp.com/)
