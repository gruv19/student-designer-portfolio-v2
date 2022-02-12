<template>
  <header class="home">
    <Contacts />
    <MainInfo />
    <Button link="/#works" text="Учебные работы" />
  </header>
</template>

<script>
import Contacts from './Contacts.vue';
import MainInfo from './MainInfo.vue';
import Button from './Button.vue';

export default {
  name: 'Home',
  components: {
    Contacts, MainInfo, Button,
  },
};
</script>
