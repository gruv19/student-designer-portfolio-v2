import axios from 'axios';

const BASE_URL = process.env.NODE_ENV === 'development'
  ? 'http://sdp.backend:8082'
  : 'http://sdp.backend:8082';

export default {
  state: {},
  mutations: {},
  actions: {
    async typesRead() {
      const uri = `${BASE_URL}/types_read.php`;
      const result = axios.get(uri)
        .then((response) => response.data)
        .catch((error) => {
          throw new Error(error.message);
        });
      return result;
    },
    async typesCreate(context, data) {
      const { title, description } = data;
      const uri = `${BASE_URL}/types_create.php`;
      const result = axios.post(uri, {
        title,
        description,
        token: context.rootState.userToken.token,
      })
        .then((response) => response.data)
        .catch((error) => {
          const message = error.hasOwnProperty('response') // eslint-disable-line
            ? error.response.data.message
            : error.message;
          throw new Error(message);
        });
      return result;
    },
    async typesDelete(context, typeTitle) {
      const uri = `${BASE_URL}/types_delete.php`;
      const result = axios.post(uri, {
        title: typeTitle,
        token: context.rootState.userToken.token,
      })
        .then((response) => response.data)
        .catch((error) => {
          const message = error.hasOwnProperty('response') // eslint-disable-line
            ? error.response.data.message
            : error.message;
          throw new Error(message);
        });
      return result;
    },
    async typesUpdate(context, data) {
      const { title, description, condition } = data;
      const uri = `${BASE_URL}/types_update.php`;
      const result = axios.post(uri, {
        title,
        description,
        condition,
        token: context.rootState.userToken.token,
      })
        .then((response) => response.data)
        .catch((error) => {
          const message = error.hasOwnProperty('response') // eslint-disable-line
            ? error.response.data.message
            : error.message;
          throw new Error(message);
        });
      return result;
    },
  },
};
