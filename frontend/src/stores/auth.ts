import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/services/api'
import type { User, AuthResponse, ApiResponse } from '@/types'

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null)
  const token = ref<string | null>(localStorage.getItem('auth_token'))
  const loading = ref(false)

  const isAuthenticated = computed(() => !!token.value)

  /**
   * Handle user login.
   */
  async function login(credentials: any) {
    loading.value = true
    try {
      const response = await api.post<ApiResponse<AuthResponse>>('/login', credentials)
      const data = response.data.data
      token.value = data.token
      user.value = data.user
      localStorage.setItem('auth_token', data.token)
      return response.data
    } finally {
      loading.value = false
    }
  }

  /**
   * Handle user registration.
   */
  async function register(userData: any) {
    loading.value = true
    try {
      const response = await api.post<ApiResponse<User>>('/register', userData)
      return response.data
    } finally {
      loading.value = false
    }
  }

  /**
   * Handle user logout.
   */
  async function logout() {
    loading.value = true
    try {
      await api.post('/logout')
    } catch (e) {
      console.error('Logout API call failed:', e)
    } finally {
      token.value = null
      user.value = null
      localStorage.removeItem('auth_token')
      loading.value = false
    }
  }

  /**
   * Fetch user profile info.
   */
  async function fetchProfile() {
    if (!token.value) return
    loading.value = true
    try {
      const response = await api.get<ApiResponse<User>>('/profile')
      user.value = response.data.data
    } catch (error) {
      // Clear token if invalid or expired
      token.value = null
      user.value = null
      localStorage.removeItem('auth_token')
      throw error
    } finally {
      loading.value = false
    }
  }

  return {
    user,
    token,
    loading,
    isAuthenticated,
    login,
    register,
    logout,
    fetchProfile,
  }
})
