<template>
  <Head title="Marko Inertia Stack" />

  <div class="min-h-screen bg-stone-50 text-slate-950">
    <nav class="fixed inset-x-0 top-0 z-50 border-b border-slate-200 bg-stone-50/95 backdrop-blur">
      <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-5">
        <Link href="/" class="flex items-center gap-3">
          <span class="flex h-9 w-9 items-center justify-center rounded bg-slate-950 text-sm font-bold text-white">M</span>
          <span class="text-sm font-semibold">Marko Inertia</span>
        </Link>

        <div class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
          <a href="#features" class="hover:text-slate-950">Features</a>
          <a href="#workflow" class="hover:text-slate-950">Workflow</a>
          <a href="https://marko.build/docs" target="_blank" class="hover:text-slate-950">Docs</a>
        </div>

        <Link
          href="/login"
          class="inline-flex h-10 w-10 items-center justify-center gap-2 rounded bg-slate-950 text-sm font-semibold text-white hover:bg-slate-800 sm:w-auto sm:px-4"
        >
          <span class="hidden sm:inline">Sign in</span>
          <svg width="16" height="16" class="shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
          </svg>
        </Link>
      </div>
    </nav>

    <header class="relative isolate overflow-hidden border-b border-slate-200 bg-stone-100 pt-16">
      <div class="absolute inset-0 opacity-40 hero-grid" />

      <div
        class="pointer-events-none absolute right-[max(-260px,calc((100vw-72rem)/2-180px))] top-24 hidden w-[760px] xl:block"
        aria-hidden="true"
      >
        <div class="ml-auto w-[620px] rounded border border-slate-300 bg-white/95 shadow-2xl shadow-slate-300/40">
          <div class="flex h-10 items-center gap-2 border-b border-slate-200 px-4">
            <span class="h-2.5 w-2.5 rounded-full bg-red-400" />
            <span class="h-2.5 w-2.5 rounded-full bg-amber-400" />
            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500" />
            <span class="ml-3 text-xs text-slate-500">Dashboard.vue</span>
          </div>
          <div class="grid grid-cols-[160px_1fr]">
            <div class="border-r border-slate-200 bg-slate-950 p-4 text-xs text-slate-400">
              <p class="mb-5 text-white">Marko</p>
              <p class="mb-3 rounded bg-white/10 px-3 py-2 text-white">Dashboard</p>
              <p class="mb-3 px-3 py-2">Profile</p>
              <p class="px-3 py-2">Orders</p>
            </div>
            <div class="p-5">
              <div class="mb-4 flex items-center justify-between">
                <div>
                  <div class="mb-2 h-4 w-28 rounded bg-slate-900" />
                  <div class="h-3 w-44 rounded bg-slate-200" />
                </div>
                <div class="h-9 w-24 rounded bg-emerald-500" />
              </div>
              <div class="mb-4 grid grid-cols-3 gap-3">
                <div class="h-20 rounded border border-slate-200 bg-blue-50" />
                <div class="h-20 rounded border border-slate-200 bg-emerald-50" />
                <div class="h-20 rounded border border-slate-200 bg-amber-50" />
              </div>
              <div class="h-28 rounded border border-slate-200 bg-white p-4">
                <div class="mb-3 h-2 w-full rounded bg-slate-200" />
                <div class="mb-3 h-2 w-5/6 rounded bg-slate-200" />
                <div class="h-2 w-2/3 rounded bg-slate-200" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="relative mx-auto flex min-h-[78vh] max-w-6xl flex-col justify-center px-5 py-20">
        <div class="w-full max-w-[22rem] min-w-0 sm:max-w-2xl">
          <p class="mb-5 inline-flex rounded border border-emerald-200 bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-800">
            Inertia.js, Vue 3, SSR, and Vite for Marko
          </p>
          <h1 class="max-w-full text-4xl font-bold leading-tight text-slate-950 sm:text-5xl sm:leading-none md:text-6xl">
            <span class="block">Build Marko apps</span>
            <span class="block">with Inertia.</span>
          </h1>
          <p class="mt-6 max-w-xl text-base leading-8 text-slate-700 sm:text-lg">
            Turn PHP controllers into Vue pages with server-provided props, client-side navigation, SSR, forms, and fast Vite development.
          </p>
          <div class="mt-9 flex flex-col gap-3 sm:flex-row">
            <Link
              href="/dashboard"
              class="inline-flex h-12 w-full items-center justify-center gap-2 rounded bg-blue-700 px-5 text-sm font-semibold text-white hover:bg-blue-600 sm:w-auto"
            >
              Open the demo
              <svg width="18" height="18" class="shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
              </svg>
            </Link>
            <a
              href="#workflow"
              class="inline-flex h-12 w-full items-center justify-center rounded border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-950 hover:border-slate-500 sm:w-auto"
            >
              See the request flow
            </a>
          </div>
        </div>
      </div>
    </header>

    <main>
      <section id="features" class="border-b border-slate-200 bg-white px-5 py-20">
        <div class="mx-auto max-w-6xl">
          <div class="max-w-2xl">
            <p class="mb-3 text-sm font-semibold text-blue-700">Full stack without the split brain</p>
            <h2 class="text-3xl font-bold text-slate-950 md:text-4xl">What the Inertia module adds to Marko</h2>
          </div>

          <div class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            <article
              v-for="feature in features"
              :key="feature.title"
              class="rounded border border-slate-200 bg-stone-50 p-6"
            >
              <div :class="['mb-5 flex h-10 w-10 items-center justify-center rounded text-white', feature.color]">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" :d="feature.icon" />
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-slate-950">{{ feature.title }}</h3>
              <p class="mt-3 text-sm leading-6 text-slate-600">{{ feature.copy }}</p>
            </article>
          </div>
        </div>
      </section>

      <section id="workflow" class="border-b border-slate-200 bg-stone-50 px-5 py-20">
        <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
          <div>
            <p class="mb-3 text-sm font-semibold text-emerald-700">The request flow</p>
            <h2 class="text-3xl font-bold text-slate-950 md:text-4xl">Keep routing, auth, and data in PHP. Render the screen in Vue.</h2>
            <p class="mt-5 text-base leading-7 text-slate-700">
              Marko handles the request and passes page props into Inertia. Vue receives those props as the initial page state, then Inertia takes over navigation with JSON responses.
            </p>
          </div>

          <div class="grid gap-4">
            <div
              v-for="step in flow"
              :key="step.title"
              class="grid grid-cols-[48px_1fr] gap-4 rounded border border-slate-200 bg-white p-5"
            >
              <div class="flex h-12 w-12 items-center justify-center rounded bg-slate-950 text-sm font-bold text-white">
                {{ step.number }}
              </div>
              <div>
                <h3 class="font-semibold text-slate-950">{{ step.title }}</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ step.copy }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="border-b border-slate-200 bg-white px-5 py-20">
        <div class="mx-auto max-w-6xl">
          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="min-w-0 rounded border border-slate-800 bg-slate-950">
              <div class="flex h-11 items-center gap-2 border-b border-slate-800 px-4">
                <span class="h-2.5 w-2.5 rounded-full bg-red-400" />
                <span class="h-2.5 w-2.5 rounded-full bg-amber-400" />
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500" />
                <span class="ml-2 text-xs text-slate-500">HomeController.php</span>
              </div>
              <pre class="max-w-full overflow-x-auto p-5 text-sm leading-7 text-slate-300"><code><span class="text-blue-300">#[Get</span>(<span class="text-emerald-300">'/profile'</span>)]
<span class="text-blue-300">public function</span> profile(Request <span class="text-slate-500">$request</span>): Response
{
    <span class="text-slate-500">$user</span> = <span class="text-slate-500">$this</span>->auth->user();

    <span class="text-blue-300">return</span> <span class="text-slate-500">$this</span>->inertia->render(
        <span class="text-slate-500">$request</span>,
        <span class="text-emerald-300">'Profile'</span>,
        [<span class="text-emerald-300">'user'</span> => <span class="text-slate-500">$user</span>?->toArray()]
    );
}</code></pre>
            </div>

            <div class="rounded border border-slate-200 bg-stone-50 p-6">
              <p class="mb-3 text-sm font-semibold text-amber-700">Developer experience</p>
              <h2 class="text-3xl font-bold text-slate-950">One command runs the stack.</h2>
              <p class="mt-4 text-base leading-7 text-slate-700">
                The skeleton starts PHP, Vite, and the Inertia SSR server together for local development. The same module system discovers controllers and Vue pages from app modules.
              </p>
              <div class="mt-6 rounded bg-slate-950 p-5 font-mono text-sm text-slate-300">
                <p class="text-slate-500"># PHP + Vite + SSR</p>
                <p>composer dev</p>
                <p class="mt-4 text-slate-500"># Build browser and SSR assets</p>
                <p>composer build</p>
              </div>
              <div class="mt-6 grid grid-cols-1 gap-3 text-sm text-slate-700 sm:grid-cols-2">
                <p class="rounded border border-slate-200 bg-white p-3">Vite HMR for Vue pages</p>
                <p class="rounded border border-slate-200 bg-white p-3">SSR-ready first response</p>
                <p class="rounded border border-slate-200 bg-white p-3">Inertia links and forms</p>
                <p class="rounded border border-slate-200 bg-white p-3">PHP attributes for routes</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="bg-slate-950 px-5 py-16 text-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-6 md:flex-row md:items-center md:justify-between">
          <div>
            <p class="mb-2 text-sm font-semibold text-emerald-300">Ready in this skeleton</p>
            <h2 class="text-3xl font-bold">Ship a Marko app with a modern Vue frontend.</h2>
          </div>
          <div class="flex flex-col gap-3 sm:flex-row">
            <Link
              href="/dashboard"
              class="inline-flex h-12 items-center justify-center gap-2 rounded bg-white px-5 text-sm font-semibold text-slate-950 hover:bg-slate-100"
            >
              Launch demo
              <svg width="18" height="18" class="shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
              </svg>
            </Link>
            <a
              href="https://github.com/marko-php/framework"
              target="_blank"
              class="inline-flex h-12 items-center justify-center rounded border border-white/20 px-5 text-sm font-semibold text-white hover:border-white/50"
            >
              View on GitHub
            </a>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

const features = [
  {
    title: 'Controller-driven pages',
    copy: 'Return an Inertia page from a Marko controller and pass typed PHP data directly into Vue props.',
    color: 'bg-blue-700',
    icon: 'M4 6h16M4 12h16M4 18h7',
  },
  {
    title: 'Client navigation',
    copy: 'Inertia links preserve the single-page feel while Marko keeps ownership of routes, middleware, auth, and responses.',
    color: 'bg-emerald-600',
    icon: 'M13 5h6m0 0v6m0-6L10 14M5 19h6',
  },
  {
    title: 'Vue page discovery',
    copy: 'Page components are discovered from module resource folders, so each Marko module can ship its own frontend screens.',
    color: 'bg-amber-600',
    icon: 'M4 5h7v7H4zM13 5h7v7h-7zM4 14h7v5H4zM13 14h7v5h-7z',
  },
  {
    title: 'SSR support',
    copy: 'The included SSR bridge renders the initial page on the server, improving first response quality and reducing blank states.',
    color: 'bg-slate-800',
    icon: 'M12 3v18m9-9H3',
  },
  {
    title: 'Vite development',
    copy: 'Run hot module replacement in development and emit manifest-backed browser and SSR builds for production.',
    color: 'bg-red-600',
    icon: 'M13 10V3L4 14h7v7l9-11z',
  },
  {
    title: 'Forms and validation',
    copy: 'Use Inertia form helpers for submissions while Marko middleware and controllers handle validation and redirects.',
    color: 'bg-cyan-700',
    icon: 'M9 12h6m-6 4h6M7 4h10l2 2v14H5V6z',
  },
];

const flow = [
  {
    number: '01',
    title: 'A Marko route receives the request',
    copy: 'Attribute routing and middleware run first, so authentication, sessions, and module behavior stay server-side.',
  },
  {
    number: '02',
    title: 'The controller returns an Inertia page',
    copy: 'The response includes the Vue component name, props, current URL, and asset version.',
  },
  {
    number: '03',
    title: 'Vue hydrates the page',
    copy: 'The browser receives SSR HTML when enabled, then the Vue app hydrates and Inertia takes over navigation.',
  },
  {
    number: '04',
    title: 'Subsequent visits use JSON',
    copy: 'Inertia requests return page JSON instead of full HTML, keeping navigation fast without building a separate API.',
  },
];
</script>

<style scoped>
.hero-grid {
  background-image:
    linear-gradient(to right, rgba(15, 23, 42, 0.08) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(15, 23, 42, 0.08) 1px, transparent 1px);
  background-size: 42px 42px;
}
</style>
