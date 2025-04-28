/**
 * router/index.ts
 *
 * Automatic routes for `./src/pages/*.vue`
 */

// Composables
import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router/auto'
import Default from '@/layouts/default.vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'
import { useAuthStore } from '@/stores/auth' 
import { navItems } from '@/components/NavItems/nav-items'
import Dashboard from '@/pages/Dashboard.vue'
import ManageUsers from '@/pages/ManageUsers.vue'
import Settings from '@/pages/Settings.vue'
import Profile from '@/pages/Profile.vue'

const baseRoutes: RouteRecordRaw[] = [
  {
    path: '/',
    redirect: '/login',
  },
  {
    path: '/login',
    component: Default,
  }
];



const routes = [
  ...baseRoutes,
  {
    path: '/',
    component: DashboardLayout,
    children: [
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta: {
          requiresAuth: true,
          roles: ['admin', 'user'],
        }
      },
      {
        path: 'manage-users',
        name: 'ManageUsers',
        component: ManageUsers,
        meta: {
          requiresAuth: true,
          roles: ['admin'],
        }
      },
      {
        path: 'profile',
        name: 'Profile',
        component: Profile,
      }
    ],
    meta: { requiresAuth: true, },
  }
]
const router = createRouter({
 history: createWebHistory(),
 routes
})

// Route Guards
router.beforeEach((to, from, next) => { 
  const authStore = useAuthStore()

  if(to.meta.requiresAuth && !authStore.token) {
    next('/login')
  }

  if (to.path !== '/login' && !authStore.token) {
    return next('/login');
  }

  const allowedRoles = to.meta.roles as string[] || [];
  if (allowedRoles.length > 0 && !allowedRoles.includes(authStore.role)) {
    next('/')
  } else {
    next()
  }
})

export default router
