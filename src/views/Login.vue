<template>
  <div class="login">
    <h1 class="login__title">Панель администратора</h1>
    <form action="" class="login__form" method="POST" @submit.prevent="login">
      <div class="login__input login__input--email">
        <label class="login_label">Email</label>
        <BaseInput
          type="email"
          name="email"
          v-model="email"
          plcHolder="Введи email"
          @blur="blur(v$.email, 'emailModifier')"
          :modifier="emailModifier"
        />
        <div
          class="login__errors"
          v-if="v$.email.$dirty && v$.email.$error"
        >
          <InputErrors :error="v$.email.$errors[0]" />
        </div>
      </div>
      <div class="login__input login__input--password">
        <label class="login_label">Пароль</label>
        <BaseInput
          type="password"
          name="password"
          v-model="password"
          plcHolder="Введи пароль"
          @blur="blur(v$.password, 'passwordModifier')"
          :modifier="passwordModifier"
        />
        <div
          class="login__errors"
          v-if="v$.password.$dirty && v$.password.$error"
        >
          <InputErrors :error="v$.password.$errors[0]" />
        </div>
      </div>
      <div class="login__buttons">
        <Button text="Войти" />
        <Button
          text="Вернуться на главную"
          modifier="cancel"
          type="reset"
          @click.prevent="goBack"
        />
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
      emailModifier: '',
      passwordModifier: '',
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
      this.$router.push('/');
    },
    blur(validation, modifier) {
      validation.$touch();
      if (validation.$error) {
        this[modifier] = 'invalid'; // eslint-disable-line
      } else {
        this[modifier] = 'valid'; // eslint-disable-line
      }
    },
  },
};
</script>
