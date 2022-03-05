import { createStore } from 'vuex';

export default createStore({
  state: {
    activeFilter: '',
  },
  mutations: {
    setActiveFilter(state, filterName) {
      state.activeFilter = filterName;
    },
  },
  actions: {
    async fetchWorkTypes() {
      const data = await fetch('/api/getWorkTypes.php');
      const result = await data.json();
      return result;
    },
    async fetchWorks() {
      const data = await fetch('/api/getWorks.php');
      const result = await data.json();
      return result;
    },
    async fetchWork(id) {
      const data = await fetch(`/api/getWorkData.php?work_id=${id}`);
      const result = await data.json();
      return result;
    },
  },
  modules: {
  },
});
