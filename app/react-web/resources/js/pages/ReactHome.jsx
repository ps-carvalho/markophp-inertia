import { Head, Link } from '@inertiajs/react';

export default function ReactHome({ framework, features }) {
  return (
    <>
      <Head title="Marko Inertia React" />
      <main className="min-h-screen bg-slate-950 text-white">
        <section className="mx-auto flex min-h-screen max-w-5xl flex-col justify-center px-6 py-16">
          <p className="mb-4 text-sm font-semibold uppercase tracking-wider text-blue-300">
            Marko + Inertia + {framework}
          </p>
          <h1 className="max-w-3xl text-5xl font-bold leading-tight md:text-7xl">
            React pages from Marko controllers.
          </h1>
          <p className="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
            This route is served by an independent Marko module, rendered through the React Inertia adapter, and bundled by its own Vite entry.
          </p>

          <div className="mt-10 grid gap-3 md:grid-cols-2">
            {features.map((feature) => (
              <div key={feature} className="rounded border border-white/10 bg-white/5 p-4 text-sm text-slate-200">
                {feature}
              </div>
            ))}
          </div>

          <div className="mt-10 flex flex-col gap-3 sm:flex-row">
            <Link href="/" className="inline-flex h-12 items-center justify-center rounded bg-white px-5 text-sm font-semibold text-slate-950">
              Vue landing
            </Link>
            <Link href="/svelte" className="inline-flex h-12 items-center justify-center rounded border border-white/20 px-5 text-sm font-semibold text-white">
              Svelte demo
            </Link>
          </div>
        </section>
      </main>
    </>
  );
}
