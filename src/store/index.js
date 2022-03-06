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
      const data = await fetch('/api/getWorksCount.php');
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
      const data = await fetch('/api/getWorkTypes.php');
      const result = await data.json();
      return result;
    },
  },
  modules: {
  },
});
