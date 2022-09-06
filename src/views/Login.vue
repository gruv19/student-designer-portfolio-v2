<template>
  <div class="login">
    <h1 class="login__title">Кабинет администратора</h1>
    <form action="" class="login__form" method="POST" @submit.prevent="login">
      <div class="login__input login__input--email">
        <BaseInput
          type="email"
          name="email"
          v-model="email"
          plcHolder="Введи email"
          @blur="v$.email.$touch"
        />
        <div
          class="login__errors"
          v-if="v$.email.$dirty && v$.email.$error"
        >
          <InputErrors :errors="v$.email.$errors" />
        </div>
      </div>
      <div class="login__input login__input--password">
        <BaseInput
          type="password"
          name="password"
          v-model="password"
          plcHolder="Введи пароль"
          @blur="v$.password.$touch"
        />
        <div
          class="login__errors"
          v-if="v$.password.$dirty && v$.password.$error"
        >
          <InputErrors :errors="v$.password.$errors" />
        </div>
      </div>
      <div class="login__buttons">
        <Button text="Войти" modifier="invert" />
        <Button text="Назад" modifier="cancel" type="reset" @click.prevent="goBack" />
      </div>
    </form>
  </div>
</template>

<script>
import Button from '@/components/Button.vue';
import BaseInput from '@/components/BaseInput.vue';
import InputErrors from '@/components/InputErrors.vue';

import useVuelidate from '@vuelidate/core';
import { helpers, required, email } from '@vuelidate/validators';

export default {
  name: 'Login',
  components: { Button, BaseInput, InputErrors },
  data() {
    return {
      email: '',
      password: '',
    };
  },
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  validations() {
    return {
      email: {
        required: helpers.withMessage('Поле не должно быть пустым!', required),
        email: helpers.withMessage('Некорректный email адрес!', email),
      },
      password: {
        required: helpers.withMessage('Поле не должно быть пустым!', required),
      },
    };
  },
  methods: {
    async login() {
      const isFormCorrect = await this.v$.$validate();
      if (!isFormCorrect) {
        return; // eslint-disable-line
      }
      try {
        const answer = await this.$store.dispatch('auth', { email: this.email, password: this.password });
        this.$store.commit('setUserToken', { token: answer.data.users_token, expireDateToken: answer.data.users_token_expire_date });
        this.$router.push('/admin');
      } catch (error) {
        this.$store.dispatch('showError', error.message);
      }
    },
    goBack() {
      this.email = '';
      this.password = '';
      this.$router.go(-1);
    },
  },
};
</script>
