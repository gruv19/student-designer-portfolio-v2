<template>
  <main class="create-update-work">
    <h1 class="create-update-work__title">Страница создания/редактирования работы</h1>
    <div class="create-update-work__form">
      <WorkForm :id="id" />
    </div>
  </main>
</template>

<script>
import WorkForm from '@/components/WorkForm.vue';

export default {
  name: 'CreateUpdateWork',
  components: { WorkForm },
  props: {
    id: {
      required: false,
    },
  },
};
</script>
