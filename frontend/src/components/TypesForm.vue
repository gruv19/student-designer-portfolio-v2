<template>
  <form action="#" class="types-form" method="POST">
    <div class="types-form__input types-form__input--title">
      <BaseInput
        name="title"
        plcHolder="Введи название на английском"
        v-model.trim="title"
        @blur="v$.title.$touch"
      />
      <div
        class="types-form__errors"
        v-if="v$.title.$dirty && v$.title.$error"
      >
        <InputErrors :errors="v$.title.$errors" />
      </div>
    </div>
    <div class="types-form__input types-form__input--description">
      <BaseInput
        name="description"
        plcHolder="Введи название на русском"
        v-model.trim="description"
        @blur="v$.description.$touch"
      />
      <div
        class="types-form__errors"
        v-if="v$.description.$dirty && v$.description.$error"
      >
        <InputErrors :errors="v$.description.$errors" />
      </div>
    </div>
    <button
      class="types-form__button types-form__button--save"
      type="submit"
      @click.prevent="save"
    >
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="types-form__icon types-form__icon--save">
        <!-- eslint-disable -->
        <path d="M18.7104 7.2101C18.6175 7.11638 18.5069 7.04198 18.385 6.99121C18.2632 6.94044 18.1324 6.91431 18.0004 6.91431C17.8684 6.91431 17.7377 6.94044 17.6159 6.99121C17.494 7.04198 17.3834 7.11638 17.2904 7.2101L9.84044 14.6701L6.71044 11.5301C6.61392 11.4369 6.49998 11.3636 6.37512 11.3143C6.25026 11.2651 6.11694 11.241 5.98276 11.2433C5.84858 11.2457 5.71617 11.2744 5.59309 11.3279C5.47001 11.3814 5.35868 11.4586 5.26544 11.5551C5.1722 11.6516 5.09889 11.7656 5.04968 11.8904C5.00048 12.0153 4.97635 12.1486 4.97867 12.2828C4.98099 12.417 5.00972 12.5494 5.06321 12.6725C5.1167 12.7955 5.19392 12.9069 5.29044 13.0001L9.13044 16.8401C9.2234 16.9338 9.334 17.0082 9.45586 17.059C9.57772 17.1098 9.70843 17.1359 9.84044 17.1359C9.97245 17.1359 10.1032 17.1098 10.225 17.059C10.3469 17.0082 10.4575 16.9338 10.5504 16.8401L18.7104 8.68011C18.8119 8.58646 18.893 8.47281 18.9484 8.34631C19.0038 8.21981 19.0324 8.08321 19.0324 7.94511C19.0324 7.807 19.0038 7.6704 18.9484 7.5439C18.893 7.4174 18.8119 7.30375 18.7104 7.2101V7.2101Z" />
        <!-- eslint-enable -->
      </svg>
    </button>
    <button
      class="types-form__button types-form__button--cancel"
      type="reset"
      @click.prevent="close"
    >
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="types-form__icon types-form__icon--cancel">
        <!-- eslint-disable -->
        <path d="M13.4099 11.9999L17.7099 7.70994C17.8982 7.52164 18.004 7.26624 18.004 6.99994C18.004 6.73364 17.8982 6.47825 17.7099 6.28994C17.5216 6.10164 17.2662 5.99585 16.9999 5.99585C16.7336 5.99585 16.4782 6.10164 16.2899 6.28994L11.9999 10.5899L7.70994 6.28994C7.52164 6.10164 7.26624 5.99585 6.99994 5.99585C6.73364 5.99585 6.47824 6.10164 6.28994 6.28994C6.10164 6.47825 5.99585 6.73364 5.99585 6.99994C5.99585 7.26624 6.10164 7.52164 6.28994 7.70994L10.5899 11.9999L6.28994 16.2899C6.19621 16.3829 6.12182 16.4935 6.07105 16.6154C6.02028 16.7372 5.99414 16.8679 5.99414 16.9999C5.99414 17.132 6.02028 17.2627 6.07105 17.3845C6.12182 17.5064 6.19621 17.617 6.28994 17.7099C6.3829 17.8037 6.4935 17.8781 6.61536 17.9288C6.73722 17.9796 6.86793 18.0057 6.99994 18.0057C7.13195 18.0057 7.26266 17.9796 7.38452 17.9288C7.50638 17.8781 7.61698 17.8037 7.70994 17.7099L11.9999 13.4099L16.2899 17.7099C16.3829 17.8037 16.4935 17.8781 16.6154 17.9288C16.7372 17.9796 16.8679 18.0057 16.9999 18.0057C17.132 18.0057 17.2627 17.9796 17.3845 17.9288C17.5064 17.8781 17.617 17.8037 17.7099 17.7099C17.8037 17.617 17.8781 17.5064 17.9288 17.3845C17.9796 17.2627 18.0057 17.132 18.0057 16.9999C18.0057 16.8679 17.9796 16.7372 17.9288 16.6154C17.8781 16.4935 17.8037 16.3829 17.7099 16.2899L13.4099 11.9999Z" />
        <!-- eslint-enable -->
      </svg>
    </button>
  </form>
</template>

<script>
import useVuelidate from '@vuelidate/core';
import { helpers, required, maxLength } from '@vuelidate/validators';
import BaseInput from '@/components/BaseInput.vue';
import InputErrors from '@/components/InputErrors.vue';

const mustBeEng = (value) => /^[A-Z0-9 ]+$/i.test(value);
const mustBeRus = (value) => /^[А-ЯЁ0-9 ]+$/i.test(value);

export default {
  name: 'TypesForm',
  components: { BaseInput, InputErrors },
  props: {
    oldTitle: {
      type: String,
    },
    oldDescription: {
      type: String,
    },
    action: {
      type: String,
    },
  },
  data() {
    return {
      title: '',
      description: '',
    };
  },
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  validations() {
    return {
      title: {
        required: helpers.withMessage('Поле не должно быть пустым!', required),
        maxLength: helpers.withMessage('Название не может быть больше 20 символов!', maxLength(20)),
        mustBeEng: helpers.withMessage('В названии следует использовать только английские буквы и цифры', mustBeEng),
      },
      description: {
        required: helpers.withMessage('Поле не должно быть пустым!', required),
        maxLength: helpers.withMessage('Название не может быть больше 20 символов!', maxLength(20)),
        mustBeRus: helpers.withMessage('В названии следует использовать только русские буквы и цифры', mustBeRus),
      },
    };
  },
  methods: {
    save() {
      if (this.action === 'edit') {
        this.editCategory();
      } else {
        this.addNewCategory();
      }
    },
    close() {
      if (this.action === 'edit') {
        this.closeEdit();
      } else {
        this.closeCreate();
      }
    },
    async addNewCategory() {
      const isFormCorrect = await this.v$.$validate();
      if (!isFormCorrect) {
        return; // eslint-disable-line
      }
      try {
        const newType = {
          title: this.title,
          description: this.description,
          state: 'read',
        };
        await this.$store.dispatch('saveNewType', newType);
        this.$emit('typeSaved', newType);
        this.title = '';
        this.description = '';
        this.v$.$reset();
      } catch (error) {
        this.$store.dispatch('showError', error.message);
      }
    },
    async editCategory() {
      if (this.title === this.oldTitle && this.description === this.oldDescription) {
        this.closeEdit();
      }
      const isFormCorrect = await this.v$.$validate();
      if (!isFormCorrect) {
        return; // eslint-disable-line
      }
      try {
        const editedWorkType = {
          title: this.title,
          description: this.description,
          state: 'read',
          condition: this.oldTitle,
        };
        await this.$store.dispatch('updateWorkType', editedWorkType);
        this.$emit('typeEdited', editedWorkType);
        this.title = '';
        this.description = '';
        this.v$.$reset();
      } catch (error) {
        this.$store.dispatch('showError', error.message);
      }
    },
    closeCreate() {
      this.$emit('close');
    },
    closeEdit() {
      this.$emit('closeEdit', this.oldTitle);
    },
  },
  mounted() {
    this.title = this.oldTitle ? this.oldTitle : '';
    this.description = this.oldDescription ? this.oldDescription : '';
  },
};
</script>
