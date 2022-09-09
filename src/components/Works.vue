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
      <transition-group
        name="works__column--left"
        tag="div" class="works__column works__column--left"
        @before-enter="leftBeforeEnter"
        @enter="leftEnter"
        @leave="leftLeave"
      >
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
      </transition-group>
      <div class="works__column works__column--center"></div>
      <transition-group
        name="works__column--right"
        tag="div" class="works__column works__column--right"
        @before-enter="rightBeforeEnter"
        @enter="rightEnter"
        @leave="rightLeave"
      >
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
      </transition-group>
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
      return this.$store.state.works.workCounts;
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
      try {
        const loadedWorks = await this.$store.dispatch('fetchWorks', { from: this.works.length, filter: this.activeFilter, count: 4 });
        this.works = [...this.works, ...loadedWorks];
      } catch (error) {
        this.$store.dispatch('showError', error.message);
      }
    },
    async loadAnotherWorks(filterTitle) {
      try {
        this.works = await this.$store.dispatch('fetchWorks', { from: 0, filter: filterTitle, count: 4 });
      } catch (error) {
        this.$store.dispatch('showError', error.message);
      }
    },
    leftBeforeEnter(el) {
      el.style.opacity = 0; // eslint-disable-line
    },
    leftEnter(el, done) {
      el.style.animationName = 'enter-from-left'; // eslint-disable-line
      el.style.animationDuration = '0.6s'; // eslint-disable-line
      el.style.animationFillMode = 'forwards'; // eslint-disable-line
      done();
    },
    leftLeave(el, done) {
      el.style.animationName = 'leave-to-left'; // eslint-disable-line
      el.style.animationDuration = '0.6s'; // eslint-disable-line
      el.style.animationFillMode = 'forwards'; // eslint-disable-line
      done();
    },
    rightBeforeEnter(el) {
      el.style.opacity = 0; // eslint-disable-line
    },
    rightEnter(el, done) {
      el.style.animationName = 'enter-from-right'; // eslint-disable-line
      el.style.animationDuration = '0.6s'; // eslint-disable-line
      el.style.animationFillMode = 'forwards'; // eslint-disable-line
      done();
    },
    rightLeave(el, done) {
      el.style.animationName = 'leave-to-right'; // eslint-disable-line
      el.style.animationDuration = '0.6s'; // eslint-disable-line
      el.style.animationFillMode = 'forwards'; // eslint-disable-line
      done();
    },
  },
  async mounted() {
    try {
      await this.$store.dispatch('fetchWorkCounts');
      this.works = await this.$store.dispatch('fetchWorks', { count: 4 });
    } catch (error) {
      this.$store.dispatch('showError', error.message);
    }
  },
};
</script>
