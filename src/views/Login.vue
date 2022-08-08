<template>
  <div class="login">
    <form action="" class="login__form" method="POST" @submit.prevent="login">
      <input type="email" name="email" class="login__input" v-model.trim="email">
      <input type="password" name="password" class="login__input" v-model="password">
      <button type="submit" class="login__button">Войти</button>
    </form>
      <button class="login__button" @click.prevent="isAuth">isAuth</button>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async login() {
      const answer = await this.$store.dispatch('auth', { email: this.email, password: this.password });
      this.$store.commit('setUserToken', { token: answer.data.users_token, expireDateToken: answer.data.users_token_expire_date });
      this.$router.push('/admin');
    },
  },
};
</script>
