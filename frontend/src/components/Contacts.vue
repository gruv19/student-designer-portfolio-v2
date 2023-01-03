<template>
  <div class="contacts">
    <ul class="contacts__list">
      <li class="contacts__item" v-for="contact in contacts" :key="contact.id">
        <a class="contacts__link" :href="contact.link" target="_blank">{{ contact.title }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import store from '@/store/index';

export default {
  name: 'Contacts',
  setup() {
    const contacts = ref({});

    onMounted(async () => {
      try {
        contacts.value = await store.dispatch('contactsRead');
      } catch (error) {
        store.dispatch('showError', error.message);
      }
    });

    return { contacts };
  },
};
</script>
