import { createInertiaApp } from '@inertiajs/react';
import { renderToString } from 'react-dom/server';

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

export default async function render(page) {
  return createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => pages[name],
  });
}
