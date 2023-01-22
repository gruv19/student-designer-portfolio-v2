import axios from 'axios';

const BACKEND_HOST = process.env.VUE_APP_BACKEND_HOST;

export default {
  state: {},
  mutations: {},
  actions: {
    async contactsRead(context, all = false) {
      console.log(context);
      const uri = `${BACKEND_HOST}/contacts_read.php?all=${all}`;
      const result = axios.get(uri)
        .then((response) => response.data)
        .catch((error) => {
          throw new Error(error.message);
        });
      return result;
    },
  },
};
