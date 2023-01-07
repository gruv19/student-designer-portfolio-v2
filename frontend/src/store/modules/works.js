import axios from 'axios';

const BASE_URL = process.env.NODE_ENV === 'development' ? 'http://sdp.backend:8082' : '';

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
    async worksCount({ commit }) {
      const uri = `${BASE_URL}/works_count.php`;
      axios.get(uri)
        .then((response) => {
          const workCounts = {};
          response.data.forEach((item) => {
            workCounts[item.type] = +item.count;
          });
          const all = Object.values(workCounts).reduce((acc, curr) => acc + curr, 0);
          workCounts.all = all;
          commit('setWorkCounts', workCounts);
        })
        .catch((error) => {
          throw new Error(error.message);
        });
    },
    async worksReadImages({ commit }, id) {
      const uri = `${BASE_URL}/works_read_images.php?work_id=${id}`;
      axios.get(uri)
        .then((response) => {
          const workImages = response.data.images ? JSON.parse(response.data.images) : [];
          commit('setWorkImages', workImages);
        })
        .catch((error) => {
          throw new Error(error.message);
        });
    },
    async worksRead(context, queryParams) {
      const { from = 0, filter = 'all', count = 0 } = queryParams;
      const uri = `${BASE_URL}/works_read.php?from=${from}&filter=${filter}&count=${count}`;
      const result = axios.get(uri)
        .then((response) => response.data)
        .catch((error) => {
          throw new Error(error.message);
        });
      return result;
    },
    async worksDelete(context, workId) {
      const uri = `${BASE_URL}/works_delete.php`;
      const result = axios.post(uri, { id: workId, token: context.rootState.userToken.token })
        .then((response) => response.data)
        .catch((error) => {
          const message = error.hasOwnProperty('response') // eslint-disable-line
            ? error.response.data.message
            : error.message;
          throw new Error(message);
        });
      return result;
    },
    async worksReadOneById(context, workId) {
      const uri = `${BASE_URL}/works_read_one_by_id.php?id=${workId}`;
      const result = axios.get(uri)
        .then((response) => response.data)
        .catch((error) => {
          throw new Error(error.message);
        });
      return result;
    },
    async worksCreate(context, formData) {
      const uri = `${BASE_URL}/works_create.php`;
      const result = axios.post(uri, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
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
    async worksUpdate(context, formData) {
      const uri = `${BASE_URL}/works_update.php`;
      const result = axios.post(uri, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
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
