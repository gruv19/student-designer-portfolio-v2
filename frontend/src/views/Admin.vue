<template>
  <main class="admin">
    <header class="admin__header">
      <h1 class="admin__title">Панель администратора</h1>
      <div class="admin__buttons">
        <Button text="Выйти" @click.prevent="logout" />
      </div>
    </header>
    <section class="admin__tabs">
      <Button
        text="Разделы"
        @click.prevent="switchTab('AdminTypes')"
        :modifier="isActiveTab('AdminTypes') ? 'invert' : '' "
      />
      <Button
        text="Проекты"
        @click.prevent="switchTab('AdminWorks')"
        :modifier="isActiveTab('AdminWorks') ? 'invert' : '' "
      />
    </section>
    <section class="admin__admin-works">
      <transition name="admin__fade-" mode="out-in">
        <component :is="activeTab"></component>
      </transition>
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
  data() {
    return {
      activeTab: 'AdminTypes',
    };
  },
  methods: {
    switchTab(tabName) {
      this.activeTab = tabName;
    },
    isActiveTab(tabName) {
      return this.activeTab === tabName;
    },
    async logout() {
      try {
        const resp = await this.$store.dispatch('logout');
        if (resp) {
          this.$router.push('/login');
        }
      } catch (error) {
        this.$store.dispatch('showError', error.message);
      }
    },
  },
};
</script>
