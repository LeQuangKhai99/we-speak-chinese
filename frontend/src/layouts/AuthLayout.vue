<template>
  <div class="min-h-screen flex items-center justify-center bg-slate-950 relative overflow-hidden">
    <!-- Background grid decoration -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a_1px,transparent_1px),linear-gradient(to_bottom,#0f172a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)]"></div>

    <!-- Glowing blob decorations -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <!-- Layout container -->
    <div class="relative w-full max-w-md px-6 py-12 z-10">
      <!-- Logo/Brand header -->
      <div class="text-center mb-8">
        <img src="/logo.png" alt="We Speak Chinese Logo" class="w-24 h-24 mx-auto mb-4 rounded-3xl border border-slate-800 shadow-xl object-cover" />
        <h1 class="text-3xl font-extrabold tracking-tight text-white bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
          We Speak Chinese
        </h1>
        <p class="mt-2 text-sm text-slate-400">
          Hệ thống học từ vựng Tiếng Trung HSK & TOCFL
        </p>
      </div>

      <!-- Card body (glassmorphism) -->
      <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl shadow-2xl p-8">
        <slot />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// AuthLayout is a pure presenter component with a default slot
</script>
