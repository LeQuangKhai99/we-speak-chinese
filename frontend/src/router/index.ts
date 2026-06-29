import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Login from '@/views/Login.vue'
import Register from '@/views/Register.vue'
import Dashboard from '@/views/Dashboard.vue'
import Practice from '@/views/Practice.vue'
import Sentences from '@/views/Sentences.vue'
import ListeningTest from '@/views/ListeningTest.vue'
import Videos from '@/views/Videos.vue'
import Profile from '@/views/Profile.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/dashboard',
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: { guest: true },
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: { guest: true },
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard,
      meta: { requiresAuth: true },
    },
    {
      path: '/practice/:groupId',
      name: 'practice',
      component: Practice,
      meta: { requiresAuth: true },
    },
    {
      path: '/sentences',
      name: 'sentences',
      component: Sentences,
      meta: { requiresAuth: true },
    },
    {
      path: '/listening-test',
      name: 'listening-test',
      component: ListeningTest,
      meta: { requiresAuth: true },
    },
    {
      path: '/videos',
      name: 'videos',
      component: Videos,
      meta: { requiresAuth: true },
    },
    {
      path: '/profile',
      name: 'profile',
      component: Profile,
      meta: { requiresAuth: true },
    },
  ],
})

// Route navigation guard
router.beforeEach(async (to, _from, next) => {
  const authStore = useAuthStore()

  // Attempt to restore session if token exists but user info isn't loaded yet
  if (authStore.token && !authStore.user) {
    try {
      await authStore.fetchProfile()
    } catch (e) {
      console.error('Failed to restore user session:', e)
    }
  }

  const isAuthenticated = authStore.isAuthenticated

  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login')
  } else if (to.meta.guest && isAuthenticated) {
    next('/dashboard')
  } else {
    next()
  }
})

export default router
