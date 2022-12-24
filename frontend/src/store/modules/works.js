const BASE_URL = process.env.NODE_ENV === 'development' ? 'http://192.168.100.25' : '';

export default {
  state: {
    workCounts: {},
    workImages: [],
  },
  mutations: {
    setWorkCounts(state, workCounts) {
      state.workCounts = workCounts;
    },
    setWorkImages(state, workImages) {
      state.workImages = workImages;
    },
  },
  actions: {
    clearWorkImages({ commit }) {
      commit('setWorkImages', []);
    },
    async fetchWorkCounts({ commit }) {
      const uri = `${BASE_URL}/getWorksCount.php`;
      // let uri = '/api/getWorksCount.php';
      // if (process.env.NODE_ENV === 'development') {
      //   uri = 'http://design-student-vue-2/api/getWorksCount.php';
      // }
      const data = await fetch(uri);
      const result = await data.json();
      if (!data.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      const workCounts = {};
      result.forEach((item) => {
        workCounts[item.type] = +item.count;
      });
      const all = Object.values(workCounts).reduce((acc, curr) => acc + curr, 0);
      workCounts.all = all;
      commit('setWorkCounts', workCounts);
    },
    async fetchWorkImages({ commit }, id) {
      const uri = `${BASE_URL}/getWorkData.php?work_id=${id}`;
      // let uri = `/api/getWorkData.php?work_id=${id}`;
      // if (process.env.NODE_ENV === 'development') {
      //   uri = `http://design-student-vue-2/api/getWorkData.php?work_id=${id}`;
      // }
      const data = await fetch(uri);
      const result = await data.json();
      if (!data.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      const workImages = result.images ? JSON.parse(result.images) : [];
      commit('setWorkImages', workImages);
    },
    async fetchWorks(context, queryParams) {
      const { from = 0, filter = 'all', count = 0 } = queryParams;
      const uri = `${BASE_URL}/getWorks.php?from=${from}&filter=${filter}&count=${count}`;
      // let uri = `/api/getWorks.php?from=${from}&filter=${filter}&count=${count}`;
      // if (process.env.NODE_ENV === 'development') {
      //   uri = `http://design-student-vue-2/api/getWorks.php?from=${from}&filter=${filter}&count=${count}`;
      // }
      const data = await fetch(uri);
      const result = await data.json();
      if (!data.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async deleteWork(context, workId) {
      const uri = `${BASE_URL}/deleteWork.php`;
      // const uri = '/api/deleteWork.php';
      const response = await fetch(uri, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: workId }),
      });
      const result = await response.json();
      if (!response.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async getWorkById(context, workId) {
      const uri = `${BASE_URL}/getWorkById.php?id=${workId}`;
      // let uri = `/api/getWorkById.php?id=${workId}`;
      // if (process.env.NODE_ENV === 'development') {
      //   uri = `http://design-student-vue-2/api/getWorkById.php?id=${workId}`;
      // }
      const data = await fetch(uri);
      const result = await data.json();
      if (!data.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async saveNewWork(context, formData) {
      const uri = `${BASE_URL}/createWork.php`;
      // let uri = '/api/createWork.php';
      // if (process.env.NODE_ENV === 'development') {
      //   uri = 'http://design-student-vue-2/api/createWork.php';
      // }
      const response = await fetch(uri, {
        method: 'POST',
        'Content-Type': 'multipart/form-data',
        body: formData,
      });
      const result = await response.json();
      if (!response.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async updateWork(context, formData) {
      const uri = `${BASE_URL}/updateWork.php`;
      // let uri = '/api/updateWork.php';
      // if (process.env.NODE_ENV === 'development') {
      //   uri = 'http://design-student-vue-2/api/updateWork.php';
      // }
      const response = await fetch(uri, {
        method: 'POST',
        'Content-Type': 'multipart/form-data',
        body: formData,
      });
      const result = await response.json();
      if (!response.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
  },
};
