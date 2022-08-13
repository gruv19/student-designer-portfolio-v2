<template>
  <div class="admin-types">
    <ul class="admin-types__list">
      <li
        class="admin-types__item"
        v-for="type in types"
        :key="type.title"
      >
        <div v-if="type.state === 'read'" class="admin-types__item-row">
          <p class="admin-types__name">{{ type.description }}</p>
          <button
            @click.prevent="showEditTypeForm(type.title)"
            class="admin-types__button admin-types__button--edit"
          >Редактировать</button>
          <button
            @click.prevent="removeType(type.title)"
            class="admin-types__button admin-types__button--remove"
          >Удалить</button>
        </div>
        <div v-else class="admin-types__item-row admin-types__item-row--edit">
          <TypesForm
            @closeEdit="hideEditForm"
            @typeEdited="updateType"
            :oldTitle="type.title"
            :oldDescription="type.description"
            action="edit"
          />
        </div>
      </li>
      <li v-if="createFormState" class="admin-types__item types__item--new">
        <TypesForm @close="hideCreateForm" @typeSaved="addType" />
      </li>
    </ul>
    <button
      class="admin-types__button admin-types__button--create"
      @click.prevent="showCreateForm"
      v-if="!createFormState"
    >Новая категория</button>
  </div>
</template>

<script>
import TypesForm from '@/components/TypesForm.vue';

export default {
  name: 'AdminTypes',
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
  },
  async mounted() {
    this.types = await this.$store.dispatch('fetchWorkTypes');
    this.types = this.types.map((item) => ({ ...item, state: 'read' }));
  },
};
</script>
