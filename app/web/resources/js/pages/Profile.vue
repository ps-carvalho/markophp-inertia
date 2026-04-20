<template>
  <Head title="Profile" />
  <div class="max-w-3xl mx-auto space-y-8">
    <!-- Profile header -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
      <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"/>
      <div class="px-8 pb-8">
        <div class="relative -mt-12 mb-6">
          <div class="w-24 h-24 bg-white rounded-2xl p-1">
            <div class="w-full h-full bg-indigo-100 rounded-xl flex items-center justify-center">
              <span class="text-2xl font-bold text-indigo-700">{{ initials }}</span>
            </div>
          </div>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-gray-900">{{ user.name }}</h2>
          <p class="text-gray-500">{{ user.email }}</p>
        </div>
        <div class="mt-6 flex gap-3">
          <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium">{{ user.role || 'Developer' }}</span>
          <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-sm font-medium">Active</span>
        </div>
      </div>
    </div>

    <!-- Info cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Account Info</h3>
        <dl class="space-y-4">
          <div class="flex justify-between">
            <dt class="text-sm text-gray-500">Member since</dt>
            <dd class="text-sm font-medium text-gray-900">{{ user.joined || 'January 2024' }}</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-sm text-gray-500">Location</dt>
            <dd class="text-sm font-medium text-gray-900">{{ user.location || 'San Francisco, CA' }}</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-sm text-gray-500">Bio</dt>
            <dd class="text-sm font-medium text-gray-900 text-right">{{ user.bio || 'Full-stack developer' }}</dd>
          </div>
        </dl>
      </div>

      <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Statistics</h3>
        <dl class="space-y-4">
          <div class="flex justify-between">
            <dt class="text-sm text-gray-500">Projects</dt>
            <dd class="text-sm font-medium text-gray-900">12</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-sm text-gray-500">Tasks completed</dt>
            <dd class="text-sm font-medium text-gray-900">847</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-sm text-gray-500">Contributions</dt>
            <dd class="text-sm font-medium text-gray-900">2.4k</dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  user: { type: Object, required: true },
});

const initials = computed(() => {
  return props.user.name.split(' ').map(n => n[0]).join('').toUpperCase();
});
</script>

<script>
import AppLayout from '../layouts/AppLayout.vue';
export default { layout: AppLayout };
</script>
