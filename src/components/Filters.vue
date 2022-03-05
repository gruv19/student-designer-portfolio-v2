<template>
  <div class="filters">
    <ul class="filters__list">
      <li class="filters__item">
        <button
          class="filters__button"
          :class="{ 'filters__button--active': activeFilter === '' }"
          @click.prevent="changeActiveFilter('')"
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
import getTypes from '@/mock/types';

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
    },
  },
  async mounted() {
    if (process.env.NODE_ENV === 'development') {
      this.types = getTypes();
    } else {
      this.types = await this.$store.dispatch('fetchWorkTypes');
    }
  },
};
</script>
