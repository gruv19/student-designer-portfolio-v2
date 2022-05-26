<template>
  <article class="card">
      <div class="card__header">
        <img :src="mainImage" alt="Изображение работы" class="card__image">
        <div class="card__main-info">
          <h3 class="card__title">{{ title }}</h3>
          <Button
            text="Посмотреть"
            modifier="work-link"
            @click.prevent="openWorkPresentation(id)"
          />
        </div>
      </div>
      <div class="card__info">
        <p class="card__subtitle">{{ subtitle }}</p>
        <p class="card__task">
          {{ task }}
        </p>
        <a v-if="link" :href="link" class="card__link" target="_blank">Открыть в браузере</a>
      </div>
    </article>
</template>

<script>
import Button from './Button.vue';

export default {
  name: 'Card',
  components: {
    Button,
  },
  props: {
    id: {
      type: Number,
      required: true,
    },
    type: {
      type: Object,
      required: true,
    },
    mainImage: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    subtitle: {
      type: String,
      required: true,
    },
    task: {
      type: String,
      required: true,
    },
    link: {
      type: String,
    },
  },
  data() {
    return {
      images: [],
    };
  },
  methods: {
    openWorkPresentation(id) {
      const scrollPosition = document.documentElement.getBoundingClientRect().top * (-1);
      this.$store.commit('setScrollPosition', scrollPosition);
      this.$router.push(`/work/${id}`);
    },
  },
};
</script>
