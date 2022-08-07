<template>
  <main class="admin">
    <h1 class="admin__title">Панель администратора</h1>
    <div class="types">
      <ul class="types__list">
        <li
          class="types__item"
          v-for="type in types"
          :key="type.title"
        >
          {{ type.description }}
          <button @click.prevent="">Редактировать</button>
          <button @click.prevent="removeType(type.title)">Удалить</button>
        </li>
        <li v-if="createFormState" class="types__item types__item--new">
          <TypesForm @close="hideCreateForm" @typeSaved="addType" />
        </li>
      </ul>
      <button
        class="types__new"
        @click.prevent="showCreateForm"
        v-if="!createFormState"
      >Новая категория</button>
    </div>
  </main>
</template>

<script>
import TypesForm from '@/components/TypesForm.vue';

export default {
  name: 'Admin',
  components: { TypesForm },
  data() {
    return {
      types: [],
      createFormState: false,
    };
  },
  methods: {
    showCreateForm() {
      this.createFormState = true;
    },
    hideCreateForm() {
      this.createFormState = false;
    },
    addType(type) {
      this.types.push(type);
    },
    removeType() {

    },
  },
  async mounted() {
    this.types = await this.$store.dispatch('fetchWorkTypes');
  },
};
</script>
