<script>
  import { Link } from '@inertiajs/svelte';

  export let framework;
  export let features = [];
</script>

<svelte:head>
  <title>Marko Inertia Svelte</title>
</svelte:head>

<main class="min-h-screen bg-emerald-950 text-white">
  <section class="mx-auto flex min-h-screen max-w-5xl flex-col justify-center px-6 py-16">
    <p class="mb-4 text-sm font-semibold uppercase tracking-wider text-emerald-200">
      Marko + Inertia + {framework}
    </p>
    <h1 class="max-w-3xl text-5xl font-bold leading-tight md:text-7xl">
      Svelte pages from Marko controllers.
    </h1>
    <p class="mt-6 max-w-2xl text-lg leading-8 text-emerald-100">
      This route is served by an independent Marko module, rendered through the Svelte Inertia adapter, and bundled by its own Vite entry.
    </p>

    <div class="mt-10 grid gap-3 md:grid-cols-2">
      {#each features as feature}
        <div class="rounded border border-white/10 bg-white/5 p-4 text-sm text-emerald-50">
          {feature}
        </div>
      {/each}
    </div>

    <div class="mt-10 flex flex-col gap-3 sm:flex-row">
      <Link href="/" class="inline-flex h-12 items-center justify-center rounded bg-white px-5 text-sm font-semibold text-emerald-950">
        Vue landing
      </Link>
      <Link href="/react" class="inline-flex h-12 items-center justify-center rounded border border-white/20 px-5 text-sm font-semibold text-white">
        React demo
      </Link>
    </div>
  </section>
</main>
