export default {
  state: {},
  mutations: {},
  actions: {
    async readContacts(context, all = false) {
      let uri = `/api/getContacts.php?all=${all}`;
      if (process.env.NODE_ENV === 'development') {
        uri = `http://design-student-vue-2/api/getContacts.php?all=${all}`;
      }
      const data = await fetch(uri);
      const result = await data.json();
      if (!data.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
  },
};
