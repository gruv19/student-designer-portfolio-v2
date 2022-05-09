<template>
  <header class="home">
    <div class="home__image-container">
      <picture>
        <source
          :srcset="require('@/assets/images/main.jpg')"
          media="(min-width: 767px)"
        />
        <img
          class="home__image"
          :class="showMainImage ? 'home__image--loaded' : ''"
          :src="require('@/assets/images/main.mobile.jpg')"
          @load="showImage"
        />
      </picture>
    </div>
    <div class="home__wrapper">
      <div class="home__contacts">
        <Contacts />
      </div>
      <div class="home__main-info">
        <MainInfo />
      </div>
      <div class="home__button">
        <Button link="/#works" text="Портфолио" />
      </div>
    </div>
  </header>
</template>

<script>
import Contacts from './Contacts.vue';
import MainInfo from './MainInfo.vue';
import Button from './Button.vue';

export default {
  name: 'Home',
  components: {
    Contacts,
    MainInfo,
    Button,
  },
  data() {
    return {
      showMainImage: false,
    };
  },
  methods: {
    showImage() {
      setTimeout(() => {
        this.showMainImage = true;
      }, 100);
    },
  },
};
</script>
