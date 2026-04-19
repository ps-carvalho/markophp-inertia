<template>
  <Head title="Dashboard" />
  <div class="space-y-8">
    <!-- Welcome -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ user.name }}!</h2>
        <p class="mt-1 text-sm text-gray-500">Here's what's happening with your application today.</p>
      </div>
      <span class="text-sm text-gray-400">{{ today }}</span>
    </div>

    <!-- Stats grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Total Visits -->
      <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500">Total Visits</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">24,592</p>
          </div>
          <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600">
            <svg width="24" height="24" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-center gap-2">
          <span class="text-sm font-medium text-emerald-600">+12.5%</span>
          <span class="text-sm text-gray-400">from last month</span>
        </div>
      </div>

      <!-- Active Users -->
      <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500">Active Users</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">1,429</p>
          </div>
          <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-emerald-50 text-emerald-600">
            <svg width="24" height="24" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-center gap-2">
          <span class="text-sm font-medium text-emerald-600">+8.2%</span>
          <span class="text-sm text-gray-400">from last month</span>
        </div>
      </div>

      <!-- Revenue -->
      <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500">Revenue</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">$48,290</p>
          </div>
          <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-amber-50 text-amber-600">
            <svg width="24" height="24" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-center gap-2">
          <span class="text-sm font-medium text-red-600">-2.4%</span>
          <span class="text-sm text-gray-400">from last month</span>
        </div>
      </div>

      <!-- Tasks Done -->
      <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500">Tasks Done</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">342</p>
          </div>
          <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-purple-50 text-purple-600">
            <svg width="24" height="24" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-center gap-2">
          <span class="text-sm font-medium text-emerald-600">+18.7%</span>
          <span class="text-sm text-gray-400">from last month</span>
        </div>
      </div>
    </div>

    <!-- Charts & Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Chart placeholder -->
      <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Traffic Overview</h3>
        <div class="h-64 flex items-end justify-between gap-2 px-4">
          <div
            v-for="(bar, i) in chartData"
            :key="i"
            class="flex-1 bg-indigo-500 rounded-t-lg transition-all hover:bg-indigo-600 relative group"
            :style="{ height: bar + '%' }"
          >
            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
              {{ bar }}%
            </div>
          </div>
        </div>
        <div class="flex justify-between mt-4 px-4 text-xs text-gray-400">
          <span v-for="day in ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']" :key="day">{{ day }}</span>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
        <div class="space-y-4">
          <div v-for="(activity, i) in activities" :key="i" class="flex items-start gap-3">
            <div class="w-2 h-2 mt-2 rounded-full bg-indigo-500 shrink-0"/>
            <div>
              <p class="text-sm text-gray-900">{{ activity.title }}</p>
              <p class="text-xs text-gray-400 mt-0.5">{{ activity.time }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick actions -->
    <div class="bg-indigo-600 rounded-xl p-6 flex items-center justify-between">
      <div>
        <h3 class="text-lg font-semibold text-white">Ready to build something amazing?</h3>
        <p class="mt-1 text-indigo-100 text-sm">Marko + Inertia + Vue + Tailwind gives you everything you need.</p>
      </div>
      <Link href="/profile" class="bg-white text-indigo-600 px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-indigo-50 transition-colors">
        View Profile
      </Link>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  user: { type: Object, required: true },
  chartData: { type: Array, required: true },
  activities: { type: Array, required: true },
});

const today = computed(() => {
  return new Date().toLocaleDateString('en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
});
</script>

<script>
import AppLayout from '../layouts/AppLayout.vue';
export default { layout: AppLayout };
</script>
