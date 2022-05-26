<template>
  <div class="contacts">
    <div class="contacts__overlay" @click.prevent="hideContactsHandler" v-if="menuActivator"></div>
    <ul class="contacts__list" :class="menuActivator ? 'contacts__list--active' : ''">
      <li class="contacts__item">
        <a class="contacts__link" href="https://t.me/evg_GRU" target="_blank">Telegram</a>
      </li>
      <!-- <li class="contacts__item">
        <a class="contacts__link" href="https://www.instagram.com/gru_jess/?utm_medium=copy_link" target="_blank">Instagram</a>
      </li> -->
      <li class="contacts__item">
        <a class="contacts__link" href="mailto:evgeniya-malceva@bk.ru" target="_blank">E-mail</a>
      </li>
      <li class="contacts__item">
        <a class="contacts__link" href="https://vk.com/ev.grusheva" target="_blank">Вконтакте</a>
      </li>
      <!-- <li class="contacts__item">
        <a class="contacts__link" href="https://www.facebook.com/profile.php?id=100007436739623" target="_blank">Facebook</a>
      </li> -->
    </ul>
    <!-- <div class="contacts__button">
      <Button link="#" text="Контакты" @click.prevent="showContactsHandler" />
    </div> -->
  </div>
</template>

<script>
// import Button from '@/components/Button.vue';

export default {
  name: 'Contacts',
  // components: { Button },
  data() {
    return {
      menuActivator: false,
    };
  },
  methods: {
    showContactsHandler() {
      this.menuActivator = true;
    },
    hideContactsHandler() {
      this.menuActivator = false;
    },
  },
};
</script>
