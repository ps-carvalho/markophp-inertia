<template>
  <Head title="Sign In" />
  <div class="min-h-screen bg-slate-950 flex items-center justify-center px-6">
    <div class="w-full max-w-sm">
      <!-- Logo -->
      <div class="text-center mb-8">
        <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mx-auto mb-4">
          <span class="text-white font-bold text-lg font-mono">M</span>
        </div>
        <h1 class="text-2xl font-bold text-white">Welcome back</h1>
        <p class="text-slate-400 text-sm mt-1">Sign in to your Marko account</p>
      </div>

      <!-- Form -->
      <form
        @submit.prevent="form.post('/login')"
        class="rounded-xl border border-slate-800 bg-slate-900/60 p-6 space-y-5"
      >
        <div v-if="form.errors.message" class="rounded-lg bg-red-500/10 border border-red-500/20 p-3 text-sm text-red-400">
          {{ form.errors.message }}
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            placeholder="you@example.com"
            class="w-full px-3 py-2 rounded-lg border border-slate-700 bg-slate-800 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
          />
          <p v-if="form.errors.email" class="mt-1 text-xs text-red-400">{{ form.errors.email }}</p>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            placeholder="••••••••"
            class="w-full px-3 py-2 rounded-lg border border-slate-700 bg-slate-800 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
          />
          <p v-if="form.errors.password" class="mt-1 text-xs text-red-400">{{ form.errors.password }}</p>
        </div>

        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-indigo-600 focus:ring-indigo-500" />
            <span class="text-sm text-slate-400">Remember me</span>
          </label>
          <a href="#" class="text-sm text-indigo-400 hover:text-indigo-300 transition-colors">Forgot password?</a>
        </div>

        <button
          type="submit"
          :disabled="form.processing"
          class="w-full px-4 py-2.5 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="form.processing">Signing in...</span>
          <span v-else>Sign In</span>
        </button>
      </form>

      <p class="text-center text-sm text-slate-500 mt-6">
        Don't have an account?
        <Link href="/" class="text-indigo-400 hover:text-indigo-300 transition-colors">Back to landing</Link>
      </p>

      <!-- Demo hint -->
      <div class="mt-6 rounded-lg border border-slate-800/60 bg-slate-900/30 p-4">
        <p class="text-xs text-slate-500 font-mono mb-1">// Demo Credentials</p>
        <p class="text-xs text-slate-400 font-mono">Email: demo@example.com</p>
        <p class="text-xs text-slate-400 font-mono">Password: password</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
});
</script>
