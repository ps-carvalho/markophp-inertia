import { createInertiaApp } from '@inertiajs/react';
import '../../../web/resources/css/app.css';

const pageModules = import.meta.glob([
  '/app/**/resources/js/pages/**/*.{jsx,tsx}',
  '/modules/**/resources/js/pages/**/*.{jsx,tsx}',
], { eager: true });

function pathToName(path) {
  const match = path.match(/\/resources\/js\/pages\/(.+)\.(jsx|tsx)$/);
  return match ? match[1] : path;
}

const pages = {};
for (const [path, mod] of Object.entries(pageModules)) {
  pages[pathToName(path)] = mod.default ?? mod;
}

createInertiaApp({
  resolve: (name) => {
    const page = pages[name];
    if (!page) {
      console.error('Available React pages:', Object.keys(pages));
      throw new Error(`Unknown React page: ${name}`);
    }
    return page;
  },
});
