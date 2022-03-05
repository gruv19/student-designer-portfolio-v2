<template>
  <main class="works" id="works">
    <div class="works__filters">
      <Filters />
    </div>
    <ul class="works__cards">
      <li class="works__card"
        v-for="(work, idx) in filteredWorks"
        :key="work.id"
        :class="{'works__card--right-justified': idx >= works.length / 2}"
      >
        <Card
          :id="work.id"
          :type="work.type"
          :mainImage="work.mainImage"
          :title="work.title"
          :subtitle="work.subtitle"
          :task="work.task"
          :link="work.link"
        />
      </li>
    </ul>
  </main>
</template>

<script>
import { worksGenerate } from '@/mock/works';

import Filters from './Filters.vue';
import Card from './Card.vue';

export default {
  name: 'Works',
  components: {
    Filters, Card,
  },
  data() {
    return {
      works: [],
    };
  },
  computed: {
    filteredWorks() {
      if (this.$store.state.activeFilter === '') {
        return this.works;
      }
      return this.works.filter((work) => work.type.title === this.$store.state.activeFilter);
    },
  },
  async mounted() {
    if (process.env.NODE_ENV === 'development') {
      this.works = worksGenerate(10);
    } else {
      this.works = await this.$store.dispatch('fetchWorks');
    }
  },
};
</script>
