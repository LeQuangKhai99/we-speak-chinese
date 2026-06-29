<template>
  <div class="h-screen bg-slate-950 text-slate-100 flex overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 h-full border-r border-slate-800 bg-slate-900/40 backdrop-blur-md hidden md:flex flex-col shrink-0">
      <div class="p-6 border-b border-slate-800 flex items-center space-x-3">
        <img src="/logo.png" alt="We Speak Chinese Logo" class="w-8 h-8 rounded-lg object-cover border border-slate-800" />
        <div>
          <h2 class="text-sm font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent leading-none">
            We Speak Chinese
          </h2>
          <span class="text-[9px] text-slate-500">Cổng học tiếng Trung</span>
        </div>
      </div>

      <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
        <!-- Bảng điều khiển -->
        <router-link
          to="/dashboard"
          class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200"
          :class="route.path === '/dashboard' ? 'bg-indigo-600/10 text-indigo-400 border-l-4 border-indigo-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200'"
        >
          <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          Bảng điều khiển
        </router-link>

        <!-- Luyện mẫu câu -->
        <router-link
          to="/sentences"
          class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200"
          :class="route.path === '/sentences' ? 'bg-indigo-600/10 text-indigo-400 border-l-4 border-indigo-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200'"
        >
          <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          Luyện mẫu câu
        </router-link>

        <!-- Nghe tả tranh HSK -->
        <router-link
          to="/listening-test"
          class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200"
          :class="route.path === '/listening-test' ? 'bg-indigo-600/10 text-indigo-400 border-l-4 border-indigo-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200'"
        >
          <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
          </svg>
          Thi nghe HSK
        </router-link>

        <!-- Video bài giảng -->
        <router-link
          to="/videos"
          class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200"
          :class="route.path === '/videos' ? 'bg-indigo-600/10 text-indigo-400 border-l-4 border-indigo-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200'"
        >
          <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
          </svg>
          Video bài giảng
        </router-link>

        <!-- Trang cá nhân & Thống kê -->
        <router-link
          to="/profile"
          class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200"
          :class="route.path === '/profile' ? 'bg-indigo-600/10 text-indigo-400 border-l-4 border-indigo-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200'"
        >
          <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          Thống kê & Cá nhân
        </router-link>
      </nav>

      <div class="p-4 border-t border-slate-800 bg-slate-900/60">
        <div class="flex items-center space-x-3 mb-3">
          <div class="w-9 h-9 rounded-full bg-indigo-600/30 flex items-center justify-center text-indigo-400 font-bold border border-indigo-500/20">
            {{ userInitials }}
          </div>
          <div class="overflow-hidden">
            <h4 class="text-sm font-semibold truncate">{{ authStore.user?.name || 'Thành viên' }}</h4>
            <p class="text-xs text-slate-400 truncate">{{ authStore.user?.email }}</p>
          </div>
        </div>
        <button
          @click="handleLogout"
          class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-medium text-rose-400 bg-rose-500/5 hover:bg-rose-500/10 border border-rose-500/20 rounded-xl transition-all duration-200 cursor-pointer"
        >
          <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          Đăng xuất
        </button>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
      <!-- Top header -->
      <header class="h-16 border-b border-slate-800 bg-slate-900/30 backdrop-blur-md flex items-center justify-between px-6 md:px-8">
        <div class="flex items-center md:hidden">
          <!-- Mobile logo -->
          <h2 class="text-lg font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
            WSC
          </h2>
        </div>
        <div class="hidden md:block">
          <span class="text-sm text-slate-400">Chào mừng trở lại, <strong class="text-slate-200">{{ authStore.user?.name }}</strong></span>
        </div>

        <div class="flex items-center space-x-4">
          <span class="text-xs px-2.5 py-1 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full font-medium">Xác thực Sanctum</span>
          <button
            @click="handleLogout"
            class="md:hidden text-rose-400 hover:text-rose-300 transition-colors"
          >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
          </button>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 p-6 md:p-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const userInitials = computed(() => {
  const name = authStore.user?.name || ''
  return name.slice(0, 2).toUpperCase()
})

const handleLogout = async () => {
  await authStore.logout()
  router.push('/login')
}
</script>
