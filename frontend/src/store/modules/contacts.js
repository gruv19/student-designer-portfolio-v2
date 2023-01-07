import axios from 'axios';

const BASE_URL = process.env.NODE_ENV === 'development' ? 'http://sdp.backend:8082' : '';

export default {
  state: {},
  mutations: {},
  actions: {
    async contactsRead(context, all = false) {
      const uri = `${BASE_URL}/contacts_read.php?all=${all}`;
      const result = axios.get(uri)
        .then((response) => response.data)
        .catch((error) => {
          throw new Error(error.message);
        });
      return result;
    },
  },
};
