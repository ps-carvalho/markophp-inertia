import { createInertiaApp } from '@inertiajs/svelte';
import { render } from 'svelte/server';

const pageModules = import.meta.glob([
  '/app/**/resources/js/pages/**/*.svelte',
  '/modules/**/resources/js/pages/**/*.svelte',
], { eager: true });

function pathToName(path) {
  const match = path.match(/\/resources\/js\/pages\/(.+)\.svelte$/);
  return match ? match[1] : path;
}

const pages = {};
for (const [path, mod] of Object.entries(pageModules)) {
  pages[pathToName(path)] = mod;
}

export default async function renderPage(page) {
  const renderInertiaPage = await createInertiaApp({
    resolve: (name) => pages[name],
  });

  return renderInertiaPage(page, render);
}
