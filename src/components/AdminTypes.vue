<template>
  <div class="admin-types">
    <ul class="admin-types__list">
      <li
        class="admin-types__item"
        v-for="type in types"
        :key="type.title"
      >
        <div v-if="type.state === 'read'" class="admin-types__item-row admin-types__item-row--new">
          <p class="admin-types__name">{{ type.description }}</p>
          <button
            @click.prevent="showEditTypeForm(type.title)"
            class="admin-types__button admin-types__button--edit"
          >
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="admin-types__icon admin-types__icon--edit">
              <path d="M22 7.24002C22.0008 7.10841 21.9756 6.97795 21.9258 6.85611C21.876 6.73427 21.8027 6.62346 21.71 6.53002L17.47 2.29002C17.3766 2.19734 17.2658 2.12401 17.1439 2.07425C17.0221 2.02448 16.8916 1.99926 16.76 2.00002C16.6284 1.99926 16.4979 2.02448 16.3761 2.07425C16.2543 2.12401 16.1435 2.19734 16.05 2.29002L13.22 5.12002L2.29002 16.05C2.19734 16.1435 2.12401 16.2543 2.07425 16.3761C2.02448 16.4979 1.99926 16.6284 2.00002 16.76V21C2.00002 21.2652 2.10537 21.5196 2.29291 21.7071C2.48045 21.8947 2.7348 22 3.00002 22H7.24002C7.37994 22.0076 7.51991 21.9857 7.65084 21.9358C7.78176 21.8858 7.90073 21.8089 8.00002 21.71L18.87 10.78L21.71 8.00002C21.8013 7.9031 21.8757 7.79155 21.93 7.67002C21.9397 7.59031 21.9397 7.50973 21.93 7.43002C21.9347 7.38347 21.9347 7.33657 21.93 7.29002L22 7.24002ZM6.83002 20H4.00002V17.17L13.93 7.24002L16.76 10.07L6.83002 20ZM18.17 8.66002L15.34 5.83002L16.76 4.42002L19.58 7.24002L18.17 8.66002Z" /> <!--eslint-disable-line-->
            </svg>
          </button>
          <button
            @click.prevent="removeType(type.title)"
            class="admin-types__button admin-types__button--remove"
          >
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="admin-types__icon admin-types__icon--remove">
              <path d="M20 6H16V5C16 4.20435 15.6839 3.44129 15.1213 2.87868C14.5587 2.31607 13.7956 2 13 2H11C10.2044 2 9.44129 2.31607 8.87868 2.87868C8.31607 3.44129 8 4.20435 8 5V6H4C3.73478 6 3.48043 6.10536 3.29289 6.29289C3.10536 6.48043 3 6.73478 3 7C3 7.26522 3.10536 7.51957 3.29289 7.70711C3.48043 7.89464 3.73478 8 4 8H5V19C5 19.7956 5.31607 20.5587 5.87868 21.1213C6.44129 21.6839 7.20435 22 8 22H16C16.7956 22 17.5587 21.6839 18.1213 21.1213C18.6839 20.5587 19 19.7956 19 19V8H20C20.2652 8 20.5196 7.89464 20.7071 7.70711C20.8946 7.51957 21 7.26522 21 7C21 6.73478 20.8946 6.48043 20.7071 6.29289C20.5196 6.10536 20.2652 6 20 6ZM10 5C10 4.73478 10.1054 4.48043 10.2929 4.29289C10.4804 4.10536 10.7348 4 11 4H13C13.2652 4 13.5196 4.10536 13.7071 4.29289C13.8946 4.48043 14 4.73478 14 5V6H10V5ZM17 19C17 19.2652 16.8946 19.5196 16.7071 19.7071C16.5196 19.8946 16.2652 20 16 20H8C7.73478 20 7.48043 19.8946 7.29289 19.7071C7.10536 19.5196 7 19.2652 7 19V8H17V19Z" /> <!--eslint-disable-line-->
            </svg>
          </button>
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
    <div class="admin-types__create">
      <Button
        modifier="invert"
        text="Добавить новый раздел +"
        @click.prevent="showCreateForm"
        v-if="!createFormState"
      />
    </div>
  </div>
</template>

<script>
import TypesForm from '@/components/TypesForm.vue';
import Button from '@/components/Button.vue';

export default {
  name: 'AdminTypes',
  components: { TypesForm, Button },
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
      try {
        await this.$store.dispatch('deleteWorkType', typeTitle);
        this.types = this.types.filter((item) => item.title !== typeTitle);
      } catch (error) {
        this.$store.dispatch('showError', error.message);
      }
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
    try {
      this.types = await this.$store.dispatch('fetchWorkTypes');
      this.types = this.types.map((item) => ({ ...item, state: 'read' }));
    } catch (error) {
      this.$store.dispatch('showError', error.message);
    }
  },
};
</script>
