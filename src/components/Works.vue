<template>
  <main class="works">
    <Filters />
    <Card />
  </main>
</template>

<script>
import Filters from './Filters.vue';
import Card from './Card.vue';

export default {
  name: 'Works',
  components: {
    Filters, Card,
  },
};
</script>
