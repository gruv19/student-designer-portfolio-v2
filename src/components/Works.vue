<template>
  <main class="works" id="works">
    <div class="works__filters">
      <Filters />
    </div>
    <div class="works__cards">
      <Card
        v-for="work in works"
        :key="work.id"
        :id="work.id"
        :type="work.type"
        :mainImage="work.main_image"
        :title="work.title"
        :subtitle="work.subtitle"
        :task="work.task"
        :link="work.link"
      />
    </div>
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
  mounted() {
    this.works = worksGenerate(4);
  },
};
</script>
