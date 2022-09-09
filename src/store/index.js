import { createStore } from 'vuex';
import vuejsStorage from 'vuejs-storage';
import { notify } from '@kyvg/vue3-notification';
import types from './modules/types';
import works from './modules/works';
import contacts from './modules/contacts';

export default createStore({
  state: {
    activeFilter: 'all',
    scrollPosition: 0,
    userToken: {},
  },
  mutations: {
    setActiveFilter(state, filterName) {
      state.activeFilter = filterName;
    },
    setScrollPosition(state, scrollPosition) {
      state.scrollPosition = scrollPosition;
    },
    setUserToken(state, userToken) {
      state.userToken = userToken;
    },
  },
  actions: {
    async auth(context, data) {
      const { email, password } = data;
      let uri = '/api/login.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/login.php';
      }
      const response = await fetch(uri, {
        method: 'POST',
        credentials: 'include',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
      });
      const result = await response.json();
      if (!response.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async isAuth(context) {
      if (new Date(context.state.userToken.expireDateToken) < new Date()) {
        return false;
      }
      let uri = '/api/isAuth.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/isAuth.php';
      }
      const response = await fetch(uri, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ token: context.state.userToken.token }),
      });
      const result = await response.json();
      if (result.status === 'error') {
        return new Error(result.message);
      }
      return result.data.isAuth;
    },
    async logout(context) {
      const uri = '/api/logout.php';
      const response = await fetch(uri);
      const result = await response.json();
      if (result.status === 'error') {
        return new Error(result.message);
      }
      context.commit('setUserToken', {});
      return result.data.logout;
    },
    showError(context, message) {
      notify({
        title: 'Error!',
        text: message,
        type: 'error',
      });
    },
  },
  plugins: [
    vuejsStorage({
      keys: ['userToken'],
      namespace: 'user-token',
      driver: vuejsStorage.drivers.sessionStorage,
    }),
  ],
  modules: {
    types,
    works,
    contacts,
  },
});
