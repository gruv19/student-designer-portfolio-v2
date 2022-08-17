<template>
  <div class="login">
    <h1 class="login__title">Кабинет администратора</h1>
    <form action="" class="login__form" method="POST" @submit.prevent="login">
      <div class="login__input login__input--email">
        <BaseInput type="email" name="email" v-model="email" plcHolder="Введи email" />
      </div>
      <div class="login__input login__input--password">
        <BaseInput type="password" name="password" v-model="password" plcHolder="Введи пароль" />
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

export default {
  name: 'Login',
  components: { Button, BaseInput },
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async login() {
      console.log(this.email, this.password);
      const answer = await this.$store.dispatch('auth', { email: this.email, password: this.password });
      this.$store.commit('setUserToken', { token: answer.data.users_token, expireDateToken: answer.data.users_token_expire_date });
      this.$router.push('/admin');
    },
    goBack() {
      this.email = '';
      this.password = '';
      this.$router.go(-1);
    },
  },
};
</script>
