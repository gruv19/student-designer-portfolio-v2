import { Object } from 'core-js';
import { createStore } from 'vuex';

export default createStore({
  state: {
    activeFilter: 'all',
    workCounts: {},
    workImages: [],
    scrollPosition: 0,
  },
  mutations: {
    setActiveFilter(state, filterName) {
      state.activeFilter = filterName;
    },
    setWorkCounts(state, workCounts) {
      state.workCounts = workCounts;
    },
    setWorkImages(state, workImages) {
      state.workImages = workImages;
    },
    setScrollPosition(state, scrollPosition) {
      state.scrollPosition = scrollPosition;
    },
  },
  actions: {
    async fetchWorkCounts({ commit }) {
      let uri = '/api/getWorksCount.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/getWorksCount.php';
      }
      const data = await fetch(uri);
      const result = await data.json();
      const workCounts = {};
      result.forEach((item) => {
        workCounts[item.type] = +item.count;
      });
      const all = Object.values(workCounts).reduce((acc, curr) => acc + curr, 0);
      workCounts.all = all;
      commit('setWorkCounts', workCounts);
    },
    async fetchWorkTypes() {
      let uri = '/api/getWorkTypes.php';
      if (process.env.NODE_ENV === 'development') {
        uri = 'http://design-student-vue-2/api/getWorkTypes.php';
      }
      const data = await fetch(uri);
      const result = await data.json();
      return result;
    },
    async fetchWorkImages({ commit }, id) {
      let uri = `/api/getWorkData.php?work_id=${id}`;
      if (process.env.NODE_ENV === 'development') {
        uri = `http://design-student-vue-2/api/getWorkData.php?work_id=${id}`;
      }
      const data = await fetch(uri);
      const result = await data.json();
      const workImages = result.images ? JSON.parse(result.images) : [];
      commit('setWorkImages', workImages);
    },
    async fetchWorks(context, queryParams) {
      const { from = 0, filter = 'all', count = 0 } = queryParams;
      let uri = `/api/getWorks.php?from=${from}&filter=${filter}`;
      if (process.env.NODE_ENV === 'development') {
        uri = `http://design-student-vue-2/api/getWorks.php?from=${from}&filter=${filter}&count=${count}`;
      }
      const data = await fetch(uri);
      const result = await data.json();
      return result;
    },
    clearWorkImages({ commit }) {
      commit('setWorkImages', []);
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
      const result = await response.text();
      return result;
    },
  },
  modules: {
  },
});
