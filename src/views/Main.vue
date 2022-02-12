<template>
  <div class="main">
    <Home />
  </div>
</template>

<script>
// @ is an alias to /src
import Home from '@/components/Home.vue';

export default {
  name: 'Main',
  components: {
    Home,
  },
};
</script>
