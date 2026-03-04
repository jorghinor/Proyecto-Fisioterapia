import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Dashboard from '../views/Dashboard.vue'
import Layout from '../components/Layout.vue' // Import Layout component
import { useAuthStore } from '../store/auth'

const routes = [
  { path: '/login', component: Login },
  {
    path: '/', // This path will act as a parent for routes using the Layout
    component: Layout,
    children: [
      { path: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
      { path: 'patients', component: () => import('../views/Patients.vue'), meta: { requiresAuth: true } }, // Placeholder
      { path: 'appointments', component: () => import('../views/Appointments.vue'), meta: { requiresAuth: true } }, // Placeholder
      { path: 'therapists', component: () => import('../views/Therapists.vue'), meta: { requiresAuth: true } },
      { path: 'exercises', component: () => import('../views/Exercises.vue'), meta: { requiresAuth: true } },
      { path: 'reports', component: () => import('../views/Reports.vue'), meta: { requiresAuth: true } }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const auth = useAuthStore()
  if (to.meta.requiresAuth && !auth.token) {
    next('/login')
  } else if (to.path === '/login' && auth.token) { // If trying to access login page and already authenticated
    next('/dashboard') // Redirect to dashboard
  }
  else {
    next()
  }
})

export default router
