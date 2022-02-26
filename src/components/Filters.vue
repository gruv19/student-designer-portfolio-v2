<template>
  <div class="filters">
    <ul class="filters__list">
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
      activeFilter: 'all',
    };
  },
  methods: {
    changeActiveFilter(filterTitle) {
      this.activeFilter = filterTitle;
    },
  },
  mounted() {
    this.types = getTypes();
  },
};
</script>
