<template>
  <main class="works" id="works">
    <div class="works__filters">
      <Filters />
    </div>
    <div class="works__cards">
      <Card />
    </div>
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
