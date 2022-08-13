<template>
  <main class="admin">
    <h1 class="admin__title">Панель администратора</h1>
    <section class="admin__admin-types">
      <AdminTypes />
    </section>
    <div class="admin__buttons">
      <Button text="Выйти" @click.prevent="logout" />
    </div>
  </main>
</template>

<script>
import AdminTypes from '@/components/AdminTypes.vue';
import Button from '@/components/Button.vue';

export default {
  name: 'Admin',
  components: { AdminTypes, Button },
  methods: {
    async logout() {
      const resp = await this.$store.dispatch('logout');
      if (resp) {
        this.$router.push('/login');
      }
    },
  },
};
</script>
