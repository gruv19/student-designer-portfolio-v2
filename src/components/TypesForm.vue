<template>
  <form action="#" class="item-form" method="POST">
    <div class="input__block">
      <input
        v-model.trim="title"
        type="text"
        name="title"
        placeholder="Введите уникальное название на английском"
        class="item-form__input"
        @blur="v$.title.$touch"
      >
      <div
        class="item-form__input--errors"
        v-if="v$.title.$dirty && v$.title.$error"
      >
        <span v-for="e in v$.title.$errors" :key="e.$uid">
          <strong>{{ e.$message }}</strong>
        </span>
      </div>
    </div>
    <div class="input__block">
      <input
        v-model.trim="description"
        type="text"
        name="description"
        placeholder="Введите уникальное название на русском"
        @blur="v$.description.$touch"
      >
      <div
        class="item-form__input--errors"
        v-if="v$.description.$dirty && v$.description.$error"
      >
        <span v-for="e in v$.description.$errors" :key="e.$uid">
          <strong>{{ e.$message }}</strong>
        </span>
      </div>
    </div>
    <div v-if="action === 'edit'" class="buttons">
      <button type="submit" @click.prevent="editCategory">Сохранить</button>
      <button type="reset" @click.prevent="closeEdit">Отменить</button>
    </div>
    <div v-else class="buttons">
      <button type="submit" @click.prevent="addNewCategory">Добавить</button>
      <button type="reset" @click.prevent="close">Отменить</button>
    </div>
  </form>
</template>

<script>
import useVuelidate from '@vuelidate/core';
import { helpers, required, maxLength } from '@vuelidate/validators';

const mustBeEng = (value) => /^[A-Z0-9]+$/i.test(value);
const mustBeRus = (value) => /^[А-Я0-9]+$/i.test(value);

export default {
  name: 'TypesForm',
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
        console.log(error);
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
        console.log(error);
      }
    },
    close() {
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
