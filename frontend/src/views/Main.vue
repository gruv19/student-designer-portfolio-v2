<template>
  <div class="main">
    <Home />
    <About />
    <Works />
  </div>
</template>

<script>
import Home from '@/components/Home.vue';
import Works from '@/components/Works.vue';
import About from '@/components/About.vue';

export default {
  name: 'Main',
  components: { Home, Works, About },
  activated() {
    window.scrollTo({
      top: this.$store.state.scrollPosition,
      behavior: 'instant',
    });
  },
};
</script>
