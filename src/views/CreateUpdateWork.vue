<template>
  <main class="create-update-work">
    <h1 class="create-update-work__title">Страница создания/редактирования работы</h1>
    <div class="create-update-work__form">
      <WorksForm :id="id" />
    </div>
  </main>
</template>

<script>
import WorksForm from '@/components/WorksForm.vue';

export default {
  name: 'CreateUpdateWork',
  components: { WorksForm },
  props: {
    id: {
      required: false,
    },
  },
};
</script>
