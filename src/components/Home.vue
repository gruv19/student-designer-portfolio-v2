<template>
  <header class="home">
    <Contacts />
    <MainInfo />
    <Button />
  </header>
</template>

<script>
import Contacts from './Contacts.vue';
import MainInfo from './MainInfo.vue';
import Button from './Button.vue';

export default {
  name: 'HelloWorld',
  components: {
    Contacts, MainInfo, Button,
  },
};
</script>
