<template>
  <main class="works" id="works">
    <div class="works__filters">
      <Filters @filterChanged="loadAnotherWorks" />
    </div>
    <ul class="works__cards works__cards--mobile">
      <li class="works__card"
        v-for="work in works"
        :key="work.id"
      >
        <Card
          :id="work.id"
          :type="work.type"
          :mainImage="work.mainImage"
          :title="work.title"
          :subtitle="work.subtitle"
          :task="work.task"
          :link="work.link"
        />
      </li>
    </ul>
    <div class="works__cards works__cards--desktop">
      <div class="works__column works__column--left">
        <div
          class="works__card"
          v-for="work in leftColumnWorks"
          :key="work.id"
        >
          <Card
            :id="work.id"
            :type="work.type"
            :mainImage="work.mainImage"
            :title="work.title"
            :subtitle="work.subtitle"
            :task="work.task"
            :link="work.link"
          />
        </div>
      </div>
      <div class="works__column works__column--right">
        <div
          class="works__card"
          v-for="work in rightColumnWorks"
          :key="work.id"
        >
          <Card
            :id="work.id"
            :type="work.type"
            :mainImage="work.mainImage"
            :title="work.title"
            :subtitle="work.subtitle"
            :task="work.task"
            :link="work.link"
          />
        </div>
      </div>
    </div>
    <div
      class="works__load-more-btn"
      v-if="works.length < worksCount[activeFilter]"
    >
      <Button text="Загрузить еще" @click="loadMoreWorks" modifier="work-link" />
    </div>
  </main>
</template>

<script>

import { fetchWorks } from '@/works';
import Filters from './Filters.vue';
import Card from './Card.vue';
import Button from './Button.vue';

export default {
  name: 'Works',
  components: {
    Filters, Card, Button,
  },
  data() {
    return {
      works: [],
    };
  },
  computed: {
    activeFilter() {
      return this.$store.state.activeFilter;
    },
    worksCount() {
      return this.$store.state.workCounts;
    },
    leftColumnWorks() {
      const workList = [];
      for (let i = 0; i < this.works.length; i += 1) {
        if (i % 2 === 0) {
          workList.push(this.works[i]);
        }
      }
      return workList;
    },
    rightColumnWorks() {
      const workList = [];
      for (let i = 0; i < this.works.length; i += 1) {
        if (i % 2 === 1) {
          workList.push(this.works[i]);
        }
      }
      return workList;
    },
  },
  methods: {
    async loadMoreWorks() {
      const loadedWorks = await fetchWorks(this.works.length, this.activeFilter);
      this.works = [...this.works, ...loadedWorks];
    },
    async loadAnotherWorks(filterTitle) {
      this.works = await fetchWorks(0, filterTitle);
    },
  },
  async mounted() {
    await this.$store.dispatch('fetchWorkCounts');
    this.works = await fetchWorks(0, this.activeFilter);
  },
};
</script>
