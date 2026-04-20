import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import '../css/app.css';

// Auto-discover pages from all modules
const pageModules = import.meta.glob([
  '/app/**/resources/js/pages/**/*.vue',
  '/modules/**/resources/js/pages/**/*.vue',
], { eager: true });

/**
 * Convert a file path to a component name.
 */
function pathToName(path) {
  const match = path.match(/\/resources\/js\/pages\/(.+)\.vue$/);
  return match ? match[1] : path;
}

// Build page registry
const pages = {};
for (const [path, mod] of Object.entries(pageModules)) {
  pages[pathToName(path)] = mod;
}

createInertiaApp({
  resolve: (name) => {
    const page = pages[name];
    if (!page) {
      console.error('Available pages:', Object.keys(pages));
      throw new Error(`Unknown page: ${name}`);
    }
    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({
      render: () => h(App, props),
    })
      .use(plugin)
      .mount(el);
  },
});
