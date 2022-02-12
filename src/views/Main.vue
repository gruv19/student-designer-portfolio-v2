<template>
  <div class="main">
    <Home />
    <Works />
  </div>
</template>

<script>
import Home from '@/components/Home.vue';
import Works from '@/components/Works.vue';

export default {
  name: 'Main',
  components: {
    Home, Works,
  },
};
</script>
