import { createRouter, createWebHistory } from 'vue-router';
import Main from '../views/Main.vue';
import store from '../store';

const routes = [
  {
    path: '/',
    name: 'Main',
    component: Main,
  },
  {
    path: '/work/:id',
    name: 'WorkPresentation',
    component: () => import('../views/WorkPresentation.vue'),
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/Login.vue'),
  },
  {
    path: '/admin',
    name: 'Admin',
    meta: { requiresAuth: true },
    component: () => import('../views/Admin.vue'),
  },
  {
    path: '/create',
    name: 'Create',
    meta: { requiresAuth: true },
    component: () => import('../views/CreateUpdateWork.vue'),
  },
  {
    path: '/edit/:id',
    name: 'Edit',
    meta: { requiresAuth: true },
    props: true,
    component: () => import('../views/CreateUpdateWork.vue'),
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'pageNotFound',
    component: () => import('../views/PageNotFound.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach(async (to, from) => { // eslint-disable-line
  if (to.name === 'Main' || to.name === 'pageNotFound') {
    return; // eslint-disable-line
  }
  const authState = await store.dispatch('userIsAuth');
  if (!authState && to.meta.requiresAuth) {
    return { name: 'Login' }; // eslint-disable-line
  }
  if (authState && to.name === 'Login') {
    return { name: from.name }; // eslint-disable-line
  }
});

export default router;
