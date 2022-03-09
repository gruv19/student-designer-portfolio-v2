import { Object } from 'core-js';
import { createStore } from 'vuex';

export default createStore({
  state: {
    activeFilter: 'all',
    workCounts: {},
  },
  mutations: {
    setActiveFilter(state, filterName) {
      state.activeFilter = filterName;
    },
    setWorkCounts(state, workCounts) {
      state.workCounts = workCounts;
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
      console.log(result);
      return result;
    },
  },
  modules: {
  },
});
