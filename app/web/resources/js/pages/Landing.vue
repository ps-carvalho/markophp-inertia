<template>
  <Head title="Marko Inertia Modules" />

  <div class="min-h-screen overflow-x-hidden bg-zinc-50 text-zinc-950">
    <nav class="sticky top-0 z-40 border-b border-zinc-200 bg-zinc-50/95 backdrop-blur">
      <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-5">
        <Link href="/" class="flex items-center gap-3">
          <span class="flex h-9 w-9 items-center justify-center rounded bg-zinc-950 text-sm font-bold text-white">M</span>
          <span class="text-sm font-semibold">Marko Inertia</span>
        </Link>

        <div class="hidden items-center gap-6 text-sm font-medium text-zinc-600 md:flex">
          <a href="#adapters" class="hover:text-zinc-950">Adapters</a>
          <a href="#workflow" class="hover:text-zinc-950">Flow</a>
          <a href="https://marko.build/docs" target="_blank" class="hover:text-zinc-950">Docs</a>
        </div>

        <Link
          href="/dashboard"
          class="inline-flex h-10 items-center justify-center rounded bg-zinc-950 px-4 text-sm font-semibold text-white hover:bg-zinc-800"
        >
          Demo
        </Link>
      </div>
    </nav>

    <header class="border-b border-zinc-200 bg-white">
      <div class="mx-auto grid min-h-[760px] max-w-6xl min-w-0 grid-cols-1 gap-12 px-5 py-12 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
        <div class="w-full max-w-[350px] min-w-0 sm:max-w-2xl">
          <p class="mb-5 inline-flex rounded border border-emerald-200 bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-800">
            Inertia.js implementation for Marko modules
          </p>
          <h1 class="break-words text-3xl font-bold leading-tight text-zinc-950 sm:text-4xl md:text-6xl">
            Marko + Inertia for server driven pages.
          </h1>
          <p class="mt-6 max-w-full text-lg leading-8 text-zinc-700">
            Return Vue, React, or Svelte screens from Marko controllers. Keep routes, middleware, auth, and data loading in PHP while Inertia handles client navigation.
          </p>

          <div class="mt-9 flex flex-col gap-3 sm:flex-row">
            <Link
              href="/dashboard"
              class="inline-flex h-12 items-center justify-center gap-2 rounded bg-blue-700 px-5 text-sm font-semibold text-white hover:bg-blue-600"
            >
              Vue dashboard
              <svg width="18" height="18" class="shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
              </svg>
            </Link>
            <Link
              href="/react"
              class="inline-flex h-12 items-center justify-center rounded border border-zinc-300 bg-white px-5 text-sm font-semibold text-zinc-950 hover:border-zinc-500"
            >
              React demo
            </Link>
            <Link
              href="/svelte"
              class="inline-flex h-12 items-center justify-center rounded border border-zinc-300 bg-white px-5 text-sm font-semibold text-zinc-950 hover:border-zinc-500"
            >
              Svelte demo
            </Link>
          </div>
        </div>

        <div class="w-full max-w-[350px] min-w-0 overflow-hidden rounded border border-zinc-200 bg-zinc-950 text-white shadow-xl shadow-zinc-200 sm:max-w-none">
          <div class="flex h-11 items-center gap-2 border-b border-white/10 px-4">
            <span class="h-2.5 w-2.5 rounded-full bg-red-400" />
            <span class="h-2.5 w-2.5 rounded-full bg-amber-400" />
            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500" />
            <span class="ml-2 text-xs text-zinc-400">Inertia response</span>
          </div>
          <div class="grid min-w-0 gap-0 lg:grid-cols-[0.85fr_1.15fr]">
            <div class="min-w-0 border-b border-white/10 p-6 lg:border-b-0 lg:border-r">
              <p class="text-sm font-semibold text-emerald-300">Controller</p>
              <pre class="mt-4 max-w-full overflow-x-auto text-sm leading-7 text-zinc-300"><code><span class="text-sky-300">#[Get</span>(<span class="text-emerald-300">'/react'</span>)]
<span class="text-sky-300">public function</span> index(Request <span class="text-zinc-500">$request</span>): Response
{
    <span class="text-sky-300">return</span> <span class="text-zinc-500">$this</span>->inertia->render(
        request: <span class="text-zinc-500">$request</span>,
        component: <span class="text-emerald-300">'ReactHome'</span>,
        assetEntry: <span class="text-emerald-300">'app/react-web/.../app.jsx'</span>,
    );
}</code></pre>
            </div>
            <div class="min-w-0 p-6">
              <p class="text-sm font-semibold text-sky-300">Page payload</p>
              <div class="mt-4 space-y-3">
                <div v-for="item in payload" :key="item.label" class="rounded border border-white/10 bg-white/5 p-4">
                  <p class="text-xs uppercase text-zinc-400">{{ item.label }}</p>
                  <p class="mt-1 break-words font-mono text-sm text-zinc-100">{{ item.value }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <main>
      <section id="adapters" class="border-b border-zinc-200 bg-zinc-50 px-5 py-20">
        <div class="mx-auto max-w-6xl">
          <div class="max-w-2xl">
            <p class="mb-3 text-sm font-semibold text-blue-700">Adapter modules</p>
            <h2 class="text-3xl font-bold md:text-4xl">One Marko backend, three frontend demos.</h2>
          </div>

          <div class="mt-10 grid gap-5 md:grid-cols-3">
            <article v-for="adapter in adapters" :key="adapter.name" class="rounded border border-zinc-200 bg-white p-6">
              <div :class="['mb-5 flex h-11 w-11 items-center justify-center rounded text-sm font-bold text-white', adapter.color]">
                {{ adapter.short }}
              </div>
              <h3 class="text-lg font-semibold">{{ adapter.name }}</h3>
              <p class="mt-3 text-sm leading-6 text-zinc-600">{{ adapter.copy }}</p>
              <Link :href="adapter.href" class="mt-5 inline-flex text-sm font-semibold text-blue-700 hover:text-blue-600">
                Open {{ adapter.name }}
              </Link>
            </article>
          </div>
        </div>
      </section>

      <section id="workflow" class="border-b border-zinc-200 bg-white px-5 py-20">
        <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
          <div>
            <p class="mb-3 text-sm font-semibold text-emerald-700">Request flow</p>
            <h2 class="text-3xl font-bold md:text-4xl">Marko owns the request. Inertia owns the page transition.</h2>
            <p class="mt-5 text-base leading-7 text-zinc-700">
              The first visit returns HTML with the initial page payload. Inertia visits after that request JSON page data, so you keep a SPA feel without creating a separate API layer.
            </p>
          </div>

          <div class="grid gap-4">
            <div v-for="step in flow" :key="step.title" class="grid grid-cols-[48px_1fr] gap-4 rounded border border-zinc-200 bg-zinc-50 p-5">
              <div class="flex h-12 w-12 items-center justify-center rounded bg-zinc-950 text-sm font-bold text-white">
                {{ step.number }}
              </div>
              <div>
                <h3 class="font-semibold">{{ step.title }}</h3>
                <p class="mt-2 text-sm leading-6 text-zinc-600">{{ step.copy }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="bg-zinc-950 px-5 py-16 text-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-6 md:flex-row md:items-center md:justify-between">
          <div>
            <p class="mb-2 text-sm font-semibold text-emerald-300">Included in this demo</p>
            <h2 class="text-3xl font-bold">Vue, React, and Svelte Inertia entries are ready to inspect.</h2>
          </div>
          <div class="flex flex-col gap-3 sm:flex-row">
            <Link href="/react" class="inline-flex h-12 items-center justify-center rounded bg-white px-5 text-sm font-semibold text-zinc-950 hover:bg-zinc-100">
              React
            </Link>
            <Link href="/svelte" class="inline-flex h-12 items-center justify-center rounded border border-white/20 px-5 text-sm font-semibold text-white hover:border-white/50">
              Svelte
            </Link>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

const payload = [
  { label: 'component', value: 'ReactHome | SvelteHome | Dashboard' },
  { label: 'props', value: '{ framework, features, flash }' },
  { label: 'asset entry', value: 'per-module Vite input' },
];

const adapters = [
  {
    name: 'Vue',
    short: 'V',
    href: '/dashboard',
    color: 'bg-emerald-600',
    copy: 'The default app module demonstrates authenticated pages, shared layout, SSR, and Vite manifest assets.',
  },
  {
    name: 'React',
    short: 'R',
    href: '/react',
    color: 'bg-blue-700',
    copy: 'A separate Marko module renders React 19 pages through its own Inertia client and SSR entries.',
  },
  {
    name: 'Svelte',
    short: 'S',
    href: '/svelte',
    color: 'bg-amber-600',
    copy: 'A separate Marko module renders Svelte 5 pages while sharing the same PHP Inertia response factory.',
  },
];

const flow = [
  {
    number: '01',
    title: 'A Marko route handles the request',
    copy: 'Attributes, middleware, sessions, and module dependencies run on the PHP side first.',
  },
  {
    number: '02',
    title: 'The controller returns an Inertia page',
    copy: 'The response names a frontend component, passes props, and selects the Vite asset entry for that module.',
  },
  {
    number: '03',
    title: 'The adapter mounts the frontend',
    copy: 'Vue, React, and Svelte each boot from their own entry while reading the same Marko page payload.',
  },
  {
    number: '04',
    title: 'Later visits use JSON',
    copy: 'Inertia requests receive page JSON with Marko still enforcing backend routing and middleware.',
  },
];
</script>
