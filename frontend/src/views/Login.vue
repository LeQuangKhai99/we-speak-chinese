<template>
  <AuthLayout>
    <div class="space-y-6">
      <div>
        <h3 class="text-xl font-semibold text-slate-100">Đăng Nhập</h3>
        <p class="text-xs text-slate-400 mt-1">Vui lòng nhập tài khoản và mật khẩu để tiếp tục</p>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4">
        <!-- Error Alert -->
        <div v-if="errorMessage" class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-xl text-sm">
          {{ errorMessage }}
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Địa chỉ Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-sm text-slate-100 placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150"
            placeholder="ten@viethoc.com"
          />
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Mật khẩu</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-sm text-slate-100 placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150"
            placeholder="••••••••"
          />
        </div>

        <!-- Submit button -->
        <button
          type="submit"
          :disabled="authStore.loading"
          class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white font-medium rounded-xl text-sm transition-colors duration-150 shadow-lg shadow-indigo-600/20 cursor-pointer"
        >
          {{ authStore.loading ? 'Đang đăng nhập...' : 'Đăng Nhập' }}
        </button>
      </form>

      <div class="text-center pt-2 text-sm text-slate-400">
        Bạn chưa có tài khoản?
        <router-link to="/register" class="text-indigo-400 hover:text-indigo-300 font-medium">Đăng ký ngay</router-link>
      </div>
    </div>
  </AuthLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = reactive({
  email: '',
  password: '',
})

const errorMessage = ref('')

const handleSubmit = async () => {
  errorMessage.value = ''
  try {
    await authStore.login(form)
    router.push('/dashboard')
  } catch (error: any) {
    if (error.response?.data?.errors?.email) {
      errorMessage.value = error.response.data.errors.email[0]
    } else if (error.response?.data?.message) {
      errorMessage.value = error.response.data.message
    } else {
      errorMessage.value = 'Failed to sign in. Please verify your credentials.'
    }
  }
}
</script>
