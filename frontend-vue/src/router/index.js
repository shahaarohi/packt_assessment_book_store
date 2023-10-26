import { createRouter, createWebHistory } from 'vue-router'
import store from '../store';
const routes = [
  {
    path: '/',
    name: 'home',
    component: import('../views/HomeView.vue')
  },
  {
    path: '/login',
    name: 'login',
    component: import('../views/LoginView.vue'),
    beforeEnter: (to, from, next) => {
      if (!store.state.loggedIn) {
        next();
      } else {
        next('/');
      }
    },
  },
  {
    path: '/addBook',
    name: 'AddBook',
    component: import('../views/AddBookView.vue'),
    beforeEnter: (to, from, next) => {
      if (store.state.loggedIn && store.state.admin) {
        next();
      } else {
        next('/');
      }
    },
  },
  {
    path: '/editBook/:id',
    name: 'EditBook',
    component: import('../views/EditBookView.vue'),
    beforeEnter: (to, from, next) => {
      if (store.state.loggedIn && store.state.admin) {
        next();
      } else {
        next('/');
      }
    },
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
