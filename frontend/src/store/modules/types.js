const BASE_URL = process.env.NODE_ENV === 'development' ? 'http://192.168.100.25' : '';

export default {
  state: {},
  mutations: {},
  actions: {
    async fetchWorkTypes() {
      const uri = `${BASE_URL}/getWorkTypes.php`;
      // let uri = '/api/getWorkTypes.php';
      // if (process.env.NODE_ENV === 'development') {
      //   uri = 'http://design-student-vue-2/api/getWorkTypes.php';
      // }
      const data = await fetch(uri);
      const result = await data.json();
      if (!data.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async saveNewType(context, data) {
      const { title, description } = data;
      const uri = `${BASE_URL}/createWorkTypes.php`;
      // let uri = '/api/createWorkTypes.php';
      // if (process.env.NODE_ENV === 'development') {
      //   uri = 'http://design-student-vue-2/api/createWorkTypes.php';
      // }
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
      const uri = `${BASE_URL}/deleteWorkType.php`;
      // let uri = '/api/deleteWorkType.php';
      // if (process.env.NODE_ENV === 'development') {
      //   uri = 'http://design-student-vue-2/api/deleteWorkType.php';
      // }
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
      const uri = `${BASE_URL}/updateWorkType.php`;
      // let uri = '/api/updateWorkType.php';
      // if (process.env.NODE_ENV === 'development') {
      //   uri = 'http://design-student-vue-2/api/updateWorkType.php';
      // }
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
