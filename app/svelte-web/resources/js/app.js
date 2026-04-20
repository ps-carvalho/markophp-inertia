import { createInertiaApp } from '@inertiajs/svelte';
import '../../../web/resources/css/app.css';

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

createInertiaApp({
  resolve: (name) => {
    const page = pages[name];
    if (!page) {
      console.error('Available Svelte pages:', Object.keys(pages));
      throw new Error(`Unknown Svelte page: ${name}`);
    }
    return page;
  },
});
