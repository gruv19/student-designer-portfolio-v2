<template>
  <div class="filters">
    <ul class="filters__list">
      <li class="filters__item">
        <button
          class="filters__button"
          :class="{ 'filters__button--active': activeFilter === 'all' }"
          @click.prevent="changeActiveFilter('all')"
        >
          Все
        </button>
      </li>
      <li
        class="filters__item"
        v-for="type in types"
        :key="type.title"
      >
        <button
          class="filters__button"
          :id="type.title"
          :class="{ 'filters__button--active': activeFilter === type.title }"
          @click.prevent="changeActiveFilter(type.title)"
        >
          {{ type.description }}
        </button>
      </li>
    </ul>
  </div>
</template>

<script>

export default {
  name: 'Filters',
  data() {
    return {
      types: [],
    };
  },
  computed: {
    activeFilter() {
      return this.$store.state.activeFilter;
    },
  },
  methods: {
    changeActiveFilter(filterTitle) {
      this.$store.commit('setActiveFilter', filterTitle);
      this.$emit('filterChanged', filterTitle);
    },
  },
  async mounted() {
    this.types = await this.$store.dispatch('fetchWorkTypes');
  },
};
</script>
