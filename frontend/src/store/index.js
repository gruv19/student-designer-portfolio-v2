import { createStore } from 'vuex';
import vuejsStorage from 'vuejs-storage';
import { notify } from '@kyvg/vue3-notification';
import axios from 'axios';

import types from './modules/types';
import works from './modules/works';
import contacts from './modules/contacts';

const BASE_URL = process.env.NODE_ENV === 'development'
  ? 'http://sdp.backend:8082'
  : 'http://sdp.backend:8082';

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
    async userLogin(context, data) {
      const { email, password } = data;
      const uri = `${BASE_URL}/user_login.php`;
      const result = axios.post(uri, { email, password })
        .then((response) => response.data)
        .catch((error) => {
          const message = error.hasOwnProperty('response') // eslint-disable-line
            ? error.response.data.message
            : error.message;
          throw new Error(message);
        });
      return result;
    },

    async userIsAuth(context) {
      const hasToken = context.state.userToken.hasOwnProperty('token'); // eslint-disable-line
      const tokenExpired = hasToken
        ? (new Date(context.state.userToken.expireDateToken) < new Date())
        : false;
      if (tokenExpired) {
        return false;
      }
      const uri = `${BASE_URL}/user_is_auth.php`;
      const result = axios.post(uri, { token: context.state.userToken.token })
        .then((response) => response.data.data.isAuth)
        .catch((error) => {
          throw new Error(error.message);
        });
      return result;
    },
    async logout(context) {
      const uri = `${BASE_URL}/user_logout.php`;
      const result = axios.post(uri, { token: context.state.userToken.token })
        .then((response) => response.data.data.logout)
        .catch((error) => {
          const message = error.hasOwnProperty('response') // eslint-disable-line
            ? error.response.data.message
            : error.message;
          throw new Error(message);
        });
      return result;
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
