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
export default {
  name: 'Filters',
  data() {
    return {
      types: [
        { title: 'all', description: 'Все' },
        { title: 'website', description: 'Сайты' },
        { title: 'mobile', description: 'Моб.приложения' },
      ],
      activeFilter: 'all',
    };
  },
  methods: {
    changeActiveFilter(filterTitle) {
      this.activeFilter = filterTitle;
    },
  },
};
</script>
