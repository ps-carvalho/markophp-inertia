<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200">
      <div class="flex items-center h-16 px-6 border-b border-gray-200">
        <Link href="/" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
          <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-sm">M</span>
          </div>
          <span class="text-lg font-semibold text-gray-900">Marko</span>
        </Link>
      </div>
      <nav class="p-4 space-y-1">
        <Link
          href="/dashboard"
          :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors',
            $page.component === 'Dashboard'
              ? 'bg-indigo-50 text-indigo-700'
              : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'
          ]"
        >
          <svg width="20" height="20" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          Dashboard
        </Link>
        <Link
          href="/profile"
          :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors',
            $page.component === 'Profile'
              ? 'bg-indigo-50 text-indigo-700'
              : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'
          ]"
        >
          <svg width="20" height="20" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          Profile
        </Link>
        <a
          href="/hello/world"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors"
        >
          <svg width="20" height="20" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
          </svg>
          Foo Module
        </a>
      </nav>

      <!-- User section -->
      <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center shrink-0">
            <span class="text-indigo-700 font-medium text-sm">{{ userInitials }}</span>
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-sm font-medium text-gray-900 truncate">{{ userName }}</p>
            <p class="text-xs text-gray-500 truncate">{{ userEmail }}</p>
          </div>
          <button
            @click="logout"
            class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
            title="Sign out"
          >
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main content -->
    <div class="pl-64">
      <!-- Top bar -->
      <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
        <h1 class="text-xl font-semibold text-gray-900">{{ $page.component }}</h1>
        <div class="flex items-center gap-4">
          <span class="text-sm text-gray-500">Marko Framework Demo</span>
          <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
            <span class="text-indigo-700 font-medium text-sm">{{ userInitials }}</span>
          </div>
        </div>
      </header>

      <!-- Page content -->
      <main class="p-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const $page = usePage();

const user = computed(() => $page.props.user ?? {});
const userName = computed(() => user.value.name ?? 'Guest');
const userEmail = computed(() => user.value.email ?? '');

const userInitials = computed(() => {
  const name = userName.value;
  if (!name || name === 'Guest') return 'G';
  return name.split(' ').map(n => n[0]).join('').slice(0, 2).toUpperCase();
});

function logout() {
  router.post('/logout');
}
</script>
