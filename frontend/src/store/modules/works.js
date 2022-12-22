// import { Object } from 'core-js';

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
      let uri = '/api/getWorksCount.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/getWorksCount.php';
      }
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
      let uri = `/api/getWorkData.php?work_id=${id}`;
      if (process.env.NODE_ENV === 'development') {
        uri = `http://design-student-vue-2/api/getWorkData.php?work_id=${id}`;
      }
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
      let uri = `/api/getWorks.php?from=${from}&filter=${filter}&count=${count}`;
      if (process.env.NODE_ENV === 'development') {
        uri = `http://design-student-vue-2/api/getWorks.php?from=${from}&filter=${filter}&count=${count}`;
      }
      const data = await fetch(uri);
      const result = await data.json();
      if (!data.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async deleteWork(context, workId) {
      const uri = '/api/deleteWork.php';
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
      let uri = `/api/getWorkById.php?id=${workId}`;
      if (process.env.NODE_ENV === 'development') {
        uri = `http://design-student-vue-2/api/getWorkById.php?id=${workId}`;
      }
      const data = await fetch(uri);
      const result = await data.json();
      if (!data.ok && result.status !== 'success') {
        throw new Error(result.message);
      }
      return result;
    },
    async saveNewWork(context, formData) {
      let uri = '/api/createWork.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/createWork.php';
      }
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
      let uri = '/api/updateWork.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/updateWork.php';
      }
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
