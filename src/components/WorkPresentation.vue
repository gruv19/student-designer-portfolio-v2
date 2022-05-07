<template>
  <div class="work-presentation" v-if="workImages.length" @click.self="closePresentation">
    <div class="work-presentation__button">
      <Button text="Закрыть" @click.prevent="closePresentation" modifier="close" />
    </div>
    <div class="work-presentation__image-container">
      <img
        class="work-presentation__image"
        v-for="image in workImages"
        :src="image"
        :key="image"
      >
    </div>
  </div>
</template>

<script>
import Button from './Button.vue';

export default {
  name: 'WorkPresentation',
  components: { Button },
  computed: {
    workImages() {
      return this.$store.state.workImages;
    },
  },
  methods: {
    closePresentation() {
      this.$store.dispatch('clearWorkImages');
      window.scrollTo({
        top: window.innerHeight,
        behavior: 'smooth',
      });
    },
  },
};
</script>
