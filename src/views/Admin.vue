<template>
  <main class="admin">
    <header class="admin__header">
      <h1 class="admin__title">Панель администратора</h1>
      <div class="admin__buttons">
        <Button text="Выйти" @click.prevent="logout" />
      </div>
    </header>
    <section class="admin__admin-types">
      <AdminTypes />
    </section>
    <section class="admin__admin-works">
      <AdminWorks />
    </section>
  </main>
</template>

<script>
import AdminTypes from '@/components/AdminTypes.vue';
import AdminWorks from '@/components/AdminWorks.vue';
import Button from '@/components/Button.vue';

export default {
  name: 'Admin',
  components: { AdminTypes, Button, AdminWorks },
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
