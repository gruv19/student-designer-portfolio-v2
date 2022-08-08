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
    component: () => import('../views/Admin.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach(async (to, from) => { // eslint-disable-line
  const authState = await store.dispatch('isAuth');
  if (authState === false && to.name === 'Admin') {
    return { name: 'Login' };
  }
  if (authState && to.name === 'Login') {
    return { name: from.name };
  }
});

export default router;
