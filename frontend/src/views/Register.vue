<template>
  <AuthLayout>
    <div class="space-y-6">
      <div>
        <h3 class="text-xl font-semibold text-slate-100">Đăng Ký Tài Khoản</h3>
        <p class="text-xs text-slate-400 mt-1">Bắt đầu trải nghiệm học từ vựng HSK & TOCFL</p>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4">
        <!-- Error Alert -->
        <div v-if="errorMessage" class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-xl text-sm">
          {{ errorMessage }}
        </div>

        <!-- Name -->
        <div>
          <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Họ và Tên</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-sm text-slate-100 placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150"
            placeholder="Nguyễn Văn A"
          />
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

        <!-- Password Confirmation -->
        <div>
          <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Xác nhận mật khẩu</label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
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
          {{ authStore.loading ? 'Đang đăng ký...' : 'Đăng Ký' }}
        </button>
      </form>

      <div class="text-center pt-2 text-sm text-slate-400">
        Bạn đã có tài khoản?
        <router-link to="/login" class="text-indigo-400 hover:text-indigo-300 font-medium">Đăng nhập</router-link>
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
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const errorMessage = ref('')

const handleSubmit = async () => {
  errorMessage.value = ''
  
  if (form.password !== form.password_confirmation) {
    errorMessage.value = 'Passwords do not match.'
    return
  }

  try {
    await authStore.register(form)
    await authStore.login({ email: form.email, password: form.password })
    router.push('/dashboard')
  } catch (error: any) {
    if (error.response?.data?.errors) {
      const keys = Object.keys(error.response.data.errors)
      if (keys.length > 0) {
        errorMessage.value = error.response.data.errors[keys[0]][0]
      }
    } else if (error.response?.data?.message) {
      errorMessage.value = error.response.data.message
    } else {
      errorMessage.value = 'Failed to register account. Please check your details.'
    }
  }
}
</script>
