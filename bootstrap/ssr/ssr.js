import { mergeProps, unref, useSSRContext, computed, createSSRApp, h } from "vue";
import { ssrRenderAttrs, ssrRenderClass, ssrInterpolate, ssrRenderSlot, ssrRenderList, ssrRenderStyle } from "vue/server-renderer";
import { usePage, createInertiaApp } from "@inertiajs/vue3";
import { renderToString } from "@vue/server-renderer";
import http from "http";
const _sfc_main$2 = {
  __name: "AppLayout",
  __ssrInlineRender: true,
  setup(__props) {
    const $page = usePage();
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "min-h-screen bg-gray-50" }, _attrs))}><aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200"><div class="flex items-center h-16 px-6 border-b border-gray-200"><div class="flex items-center gap-2"><div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-sm">M</span></div><span class="text-lg font-semibold text-gray-900">Marko</span></div></div><nav class="p-4 space-y-1"><a href="/dashboard" class="${ssrRenderClass([
        "flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors",
        unref($page).component === "Dashboard" ? "bg-indigo-50 text-indigo-700" : "text-gray-700 hover:bg-gray-50 hover:text-gray-900"
      ])}"><svg width="20" height="20" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg> Dashboard </a><a href="/profile" class="${ssrRenderClass([
        "flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors",
        unref($page).component === "Profile" ? "bg-indigo-50 text-indigo-700" : "text-gray-700 hover:bg-gray-50 hover:text-gray-900"
      ])}"><svg width="20" height="20" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Profile </a><a href="/hello/world" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors"><svg width="20" height="20" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg> Foo Module </a></nav></aside><div class="pl-64"><header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8"><h1 class="text-xl font-semibold text-gray-900">${ssrInterpolate(unref($page).component)}</h1><div class="flex items-center gap-4"><span class="text-sm text-gray-500">Marko Framework Demo</span><div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center"><span class="text-indigo-700 font-medium text-sm">MU</span></div></div></header><main class="p-8">`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</main></div></div>`);
    };
  }
};
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("app/web/resources/js/layouts/AppLayout.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const __default__$1 = { layout: _sfc_main$2 };
const _sfc_main$1 = /* @__PURE__ */ Object.assign(__default__$1, {
  __name: "Dashboard",
  __ssrInlineRender: true,
  props: {
    user: { type: Object, required: true },
    chartData: { type: Array, required: true },
    activities: { type: Array, required: true }
  },
  setup(__props) {
    const today = computed(() => {
      return (/* @__PURE__ */ new Date()).toLocaleDateString("en-US", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      });
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "space-y-8" }, _attrs))}><div class="flex items-center justify-between"><div><h2 class="text-2xl font-bold text-gray-900">Welcome back, ${ssrInterpolate(__props.user.name)}!</h2><p class="mt-1 text-sm text-gray-500">Here&#39;s what&#39;s happening with your application today.</p></div><span class="text-sm text-gray-400">${ssrInterpolate(today.value)}</span></div><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"><div class="bg-white rounded-xl border border-gray-200 p-6"><div class="flex items-center justify-between"><div><p class="text-sm font-medium text-gray-500">Total Visits</p><p class="mt-2 text-3xl font-bold text-gray-900">24,592</p></div><div class="w-12 h-12 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600"><svg width="24" height="24" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></div></div><div class="mt-4 flex items-center gap-2"><span class="text-sm font-medium text-emerald-600">+12.5%</span><span class="text-sm text-gray-400">from last month</span></div></div><div class="bg-white rounded-xl border border-gray-200 p-6"><div class="flex items-center justify-between"><div><p class="text-sm font-medium text-gray-500">Active Users</p><p class="mt-2 text-3xl font-bold text-gray-900">1,429</p></div><div class="w-12 h-12 rounded-lg flex items-center justify-center bg-emerald-50 text-emerald-600"><svg width="24" height="24" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div></div><div class="mt-4 flex items-center gap-2"><span class="text-sm font-medium text-emerald-600">+8.2%</span><span class="text-sm text-gray-400">from last month</span></div></div><div class="bg-white rounded-xl border border-gray-200 p-6"><div class="flex items-center justify-between"><div><p class="text-sm font-medium text-gray-500">Revenue</p><p class="mt-2 text-3xl font-bold text-gray-900">$48,290</p></div><div class="w-12 h-12 rounded-lg flex items-center justify-center bg-amber-50 text-amber-600"><svg width="24" height="24" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div></div><div class="mt-4 flex items-center gap-2"><span class="text-sm font-medium text-red-600">-2.4%</span><span class="text-sm text-gray-400">from last month</span></div></div><div class="bg-white rounded-xl border border-gray-200 p-6"><div class="flex items-center justify-between"><div><p class="text-sm font-medium text-gray-500">Tasks Done</p><p class="mt-2 text-3xl font-bold text-gray-900">342</p></div><div class="w-12 h-12 rounded-lg flex items-center justify-center bg-purple-50 text-purple-600"><svg width="24" height="24" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div></div><div class="mt-4 flex items-center gap-2"><span class="text-sm font-medium text-emerald-600">+18.7%</span><span class="text-sm text-gray-400">from last month</span></div></div></div><div class="grid grid-cols-1 lg:grid-cols-3 gap-6"><div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6"><h3 class="text-lg font-semibold text-gray-900 mb-4">Traffic Overview</h3><div class="h-64 flex items-end justify-between gap-2 px-4"><!--[-->`);
      ssrRenderList(__props.chartData, (bar, i) => {
        _push(`<div class="flex-1 bg-indigo-500 rounded-t-lg transition-all hover:bg-indigo-600 relative group" style="${ssrRenderStyle({ height: bar + "%" })}"><div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">${ssrInterpolate(bar)}% </div></div>`);
      });
      _push(`<!--]--></div><div class="flex justify-between mt-4 px-4 text-xs text-gray-400"><!--[-->`);
      ssrRenderList(["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], (day) => {
        _push(`<span>${ssrInterpolate(day)}</span>`);
      });
      _push(`<!--]--></div></div><div class="bg-white rounded-xl border border-gray-200 p-6"><h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3><div class="space-y-4"><!--[-->`);
      ssrRenderList(__props.activities, (activity, i) => {
        _push(`<div class="flex items-start gap-3"><div class="w-2 h-2 mt-2 rounded-full bg-indigo-500 shrink-0"></div><div><p class="text-sm text-gray-900">${ssrInterpolate(activity.title)}</p><p class="text-xs text-gray-400 mt-0.5">${ssrInterpolate(activity.time)}</p></div></div>`);
      });
      _push(`<!--]--></div></div></div><div class="bg-indigo-600 rounded-xl p-6 flex items-center justify-between"><div><h3 class="text-lg font-semibold text-white">Ready to build something amazing?</h3><p class="mt-1 text-indigo-100 text-sm">Marko + Inertia + Vue + Tailwind gives you everything you need.</p></div><a href="/profile" class="bg-white text-indigo-600 px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-indigo-50 transition-colors"> View Profile </a></div></div>`);
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("app/web/resources/js/pages/Dashboard.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const __vite_glob_0_0 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: _sfc_main$1
}, Symbol.toStringTag, { value: "Module" }));
const __default__ = { layout: _sfc_main$2 };
const _sfc_main = /* @__PURE__ */ Object.assign(__default__, {
  __name: "Profile",
  __ssrInlineRender: true,
  props: {
    user: { type: Object, required: true }
  },
  setup(__props) {
    const props = __props;
    const initials = computed(() => {
      return props.user.name.split(" ").map((n) => n[0]).join("").toUpperCase();
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "max-w-3xl mx-auto space-y-8" }, _attrs))}><div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div><div class="px-8 pb-8"><div class="relative -mt-12 mb-6"><div class="w-24 h-24 bg-white rounded-2xl p-1"><div class="w-full h-full bg-indigo-100 rounded-xl flex items-center justify-center"><span class="text-2xl font-bold text-indigo-700">${ssrInterpolate(initials.value)}</span></div></div></div><div><h2 class="text-2xl font-bold text-gray-900">${ssrInterpolate(__props.user.name)}</h2><p class="text-gray-500">${ssrInterpolate(__props.user.email)}</p></div><div class="mt-6 flex gap-3"><span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium">Developer</span><span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-sm font-medium">Active</span></div></div></div><div class="grid grid-cols-1 md:grid-cols-2 gap-6"><div class="bg-white rounded-xl border border-gray-200 p-6"><h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Account Info</h3><dl class="space-y-4"><div class="flex justify-between"><dt class="text-sm text-gray-500">Member since</dt><dd class="text-sm font-medium text-gray-900">January 2024</dd></div><div class="flex justify-between"><dt class="text-sm text-gray-500">Location</dt><dd class="text-sm font-medium text-gray-900">San Francisco, CA</dd></div><div class="flex justify-between"><dt class="text-sm text-gray-500">Timezone</dt><dd class="text-sm font-medium text-gray-900">PST (UTC-8)</dd></div></dl></div><div class="bg-white rounded-xl border border-gray-200 p-6"><h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Statistics</h3><dl class="space-y-4"><div class="flex justify-between"><dt class="text-sm text-gray-500">Projects</dt><dd class="text-sm font-medium text-gray-900">12</dd></div><div class="flex justify-between"><dt class="text-sm text-gray-500">Tasks completed</dt><dd class="text-sm font-medium text-gray-900">847</dd></div><div class="flex justify-between"><dt class="text-sm text-gray-500">Contributions</dt><dd class="text-sm font-medium text-gray-900">2.4k</dd></div></dl></div></div></div>`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("app/web/resources/js/pages/Profile.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const __vite_glob_0_1 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: _sfc_main
}, Symbol.toStringTag, { value: "Module" }));
const pageModules = /* @__PURE__ */ Object.assign({
  "/app/web/resources/js/pages/Dashboard.vue": __vite_glob_0_0,
  "/app/web/resources/js/pages/Profile.vue": __vite_glob_0_1
});
function pathToName(path) {
  const match = path.match(/\/resources\/js\/pages\/(.+)\.vue$/);
  return match ? match[1] : path;
}
const pages = {};
for (const [path, mod] of Object.entries(pageModules)) {
  pages[pathToName(path)] = mod;
}
const PORT = process.env.INERTIA_SSR_PORT || 13714;
const server = http.createServer(async (req, res) => {
  if (req.method !== "POST") {
    res.writeHead(405, { "Content-Type": "application/json" });
    res.end(JSON.stringify({ error: "Method not allowed" }));
    return;
  }
  let body = "";
  req.on("data", (chunk) => {
    body += chunk;
  });
  req.on("end", async () => {
    try {
      const page = JSON.parse(body);
      const pageModule = pages[page.component];
      if (!pageModule) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ error: `Unknown page: ${page.component}` }));
        return;
      }
      const { head, body: html } = await createInertiaApp({
        id: "app",
        resolve: (name) => pages[name],
        page,
        render: renderToString,
        setup({ App, props, plugin }) {
          return createSSRApp({ render: () => h(App, props) }).use(plugin);
        }
      });
      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(JSON.stringify({
        head: Array.isArray(head) ? head.join("\n") : "",
        body: html
      }));
    } catch (error) {
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ error: error.message }));
    }
  });
});
server.listen(PORT, () => {
  console.log(`Inertia SSR server running on http://localhost:${PORT}`);
});
