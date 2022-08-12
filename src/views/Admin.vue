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
          <div v-if="type.state === 'read'" class="types__item-block">
            {{ type.description }}
            <button @click.prevent="showEditTypeForm(type.title)">Редактировать</button>
            <button @click.prevent="removeType(type.title)">Удалить</button>
          </div>
          <div v-else class="types__item-block types__item-block--edit">
            <TypesForm
              @closeEdit="hideEditForm"
              @typeEdited="updateType"
              :oldTitle="type.title"
              :oldDescription="type.description"
              action="edit"
            />
          </div>
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
      <button
        class="types__logout"
        @click.prevent="logout"
      >Выйти</button>
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
    hideEditForm(typeTitle) {
      this.types = this.types.map((item) => {
        if (item.title === typeTitle) {
          item.state = 'read'; // eslint-disable-line
        }
        return item;
      });
    },
    addType(type) {
      this.types.push(type);
      this.hideCreateForm();
    },
    updateType(type) {
      this.types = this.types.map((item) => {
        if (item.title === type.condition) {
          item.title = type.title; // eslint-disable-line
          item.description = type.description; // eslint-disable-line
          item.state = type.state; // eslint-disable-line
        }
        return item;
      });
    },
    async removeType(typeTitle) {
      await this.$store.dispatch('deleteWorkType', typeTitle);
      this.types = this.types.filter((item) => item.title !== typeTitle);
    },
    showEditTypeForm(typeTitle) {
      this.types = this.types.map((item) => {
        if (item.title === typeTitle) {
          item.state = 'edit'; // eslint-disable-line
        }
        return item;
      });
    },
    async logout() {
      const resp = await this.$store.dispatch('logout');
      if (resp) {
        this.$router.push('/login');
      }
    },
  },
  async mounted() {
    this.types = await this.$store.dispatch('fetchWorkTypes');
    this.types = this.types.map((item) => ({ ...item, state: 'read' }));
  },
};
</script>
