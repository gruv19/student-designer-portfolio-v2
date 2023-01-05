<template>
  <div class="work-presentation" v-if="workImages.length" @click.self="closePresentation">
    <div class="work-presentation__button">
      <Button text="Закрыть" @click.prevent="closePresentation" modifier="work-link" />
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
import Button from '../components/Button.vue';

export default {
  name: 'WorkPresentation',
  components: { Button },
  computed: {
    workImages() {
      return this.$store.state.works.workImages;
    },
  },
  methods: {
    closePresentation() {
      this.$store.dispatch('clearWorkImages');
      this.$router.push('/');
    },
  },
  async mounted() {
    try {
      await this.$store.dispatch('worksReadImages', this.$route.params.id);
    } catch (error) {
      this.$store.dispatch('showError', error.message);
    }
  },
};
</script>
