<template>
  <div class="main">
    <WorkPresentation />
    <Home />
    <Works />
  </div>
</template>

<script>
import Home from '@/components/Home.vue';
import Works from '@/components/Works.vue';
import WorkPresentation from '@/components/WorkPresentation.vue';

export default {
  name: 'Main',
  components: {
    Home,
    Works,
    WorkPresentation,
  },
};
</script>
