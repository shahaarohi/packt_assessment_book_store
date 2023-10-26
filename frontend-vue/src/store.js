import { createStore } from 'vuex';
import { login } from './api';


export default createStore({
  state: {
    loggedIn: localStorage.getItem('authToken') || false,
    admin:  localStorage.getItem('isAdmin') === 'admin' ? true : false,
  },
  mutations: {
    login(state,isAdmin) {
        state.loggedIn = true; 
        state.admin = isAdmin;
    },
    logout(state) {
        state.loggedIn = false;
        state.admin = false;
        localStorage.removeItem('authToken');
        localStorage.removeItem('isAdmin');
    },
  },
  actions: {
    async login({ commit }, credentials) {
      try {
        const response = await login(credentials);
        if (response?.data?.success) {
          const authToken = response?.data?.data?.token; 
          const isAdmin = response?.data?.data?.isAdmin; 
          commit('login', isAdmin);
          localStorage.setItem('authToken', authToken);
          localStorage.setItem('isAdmin', isAdmin? 'admin': '');
          return { success: true, message: 'Login successful' };
        } else {
          return { success: false, message: 'Something went wrong.' };
        }
      } catch (error) {
        return error?.response?.data?.data?.error || 'Something went wrong.';
      }
    },
    logout({ commit }) {
      commit('logout');
    },
  },
});
