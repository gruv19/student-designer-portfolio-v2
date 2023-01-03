const BASE_URL = process.env.NODE_ENV === 'development' ? 'https://design-student.grv' : '';
import axios from 'axios';

export default {
  state: {},
  mutations: {},
  actions: {
    async contactsRead(context, all = false) {
      const uri = `${BASE_URL}/contacts_read.php?all=${all}`;
      const result = axios.get(uri)
        .then((response) => {
          return response.data;
        })
        .catch((error) => {
          throw new Error(error.message);
        });
      return result;
    },
  },
};
