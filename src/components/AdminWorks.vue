<template>
  <div class="admin-works">
    <ul class="admin-works__list">
      <li class="admin-works__item" v-for="work in works" :key="work.id">
        <div class="admin-works__row">
          <p class="admin-works__title">{{ work.title }}</p>
          <p class="admin-works__type">{{ work.type }}</p>
          <button
            class="admin-works__button admin-works__button--edit"
            @click.prevent="edit(work.id)"
          >Изменить</button>
          <button
            class="admin-works__button admin-works__button--remove"
            @click.prevent="remove(work.id)"
          >Удалить</button>
        </div>
      </li>
    </ul>
    <button
      class="admin-works__button admin-works__button--create"
      @click.prevent="add"
    >Добавить работу</button>
  </div>
</template>

<script>
export default {
  name: 'AdminWorks',
  data() {
    return {
      works: [],
    };
  },
  methods: {
    add() {
      this.$router.push('/create');
    },
    edit(workId) {
      this.$router.push(`/edit/${workId}`);
    },
    async remove(workId) {
      await this.$store.dispatch('deleteWork', workId);
      this.works = this.works.filter((item) => item.id !== workId);
    },
  },
  async mounted() {
    this.works = await this.$store.dispatch('fetchWorks', {});
  },
};
</script>
