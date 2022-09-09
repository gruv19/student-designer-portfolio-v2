export default {
  state: {},
  mutations: {},
  actions: {
    async fetchWorkTypes() {
      let uri = '/api/getWorkTypes.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/getWorkTypes.php';
      }
      const data = await fetch(uri);
      const result = await data.json();
      if (!data.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async saveNewType(context, data) {
      const { title, description } = data;
      let uri = '/api/createWorkTypes.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/createWorkTypes.php';
      }
      const response = await fetch(uri, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title, description }),
      });
      const result = await response.json();
      if (!response.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async deleteWorkType(context, typeTitle) {
      let uri = '/api/deleteWorkType.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/deleteWorkType.php';
      }
      const response = await fetch(uri, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title: typeTitle }),
      });
      const result = await response.json();
      if (!response.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async updateWorkType(context, data) {
      const { title, description, condition } = data;
      let uri = '/api/updateWorkType.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/updateWorkType.php';
      }
      const response = await fetch(uri, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title, description, condition }),
      });
      const result = await response.json();
      if (!response.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
  },
};
