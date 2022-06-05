<template>
  <section class="about">
    <div class="about__wrapper">
      <h2 class="about__title">Знакомьтесь,</h2>
      <h3 class="about__subtitle">
        Студент Высшей школы
        <br>
        «Среда обучения», факультет дизайна
      </h3>
      <p class="about__text">
        Люблю учиться, все работы сдаю вовремя. Разрабатывая веб-дизайн,
        сокращаю длинные тексты и углубляюсь в мысли пользователя
      </p>
      <ul class="about__list">
        <li class="about__item" v-for="skill of skills" :key="skill.id">
          <div class="about__item-overlay">
            <img :src="require(`@/assets/images/${skill.img}`)" class="about__item-image">
          </div>
          <p class="about__item-text">{{ skill.text }}</p>
        </li>
      </ul>
    </div>
  </section>
</template>

<script>
export default {
  name: 'About',
  data() {
    return {
      skills: [
        {
          id: 1,
          text: 'В 2009г получила образование по специальности Менеджмент',
          img: 'online-learning.png',
        },
        {
          id: 2,
          text: '9 лет работала администратором в сфере медицины',
          img: 'working.png',
        },
        {
          id: 3,
          text: 'Найду подход к любому человеку',
          img: 'team.png',
        },
        {
          id: 4,
          text: 'Правильно организовываю рабочий процесс',
          img: 'agenda.png',
        },
        {
          id: 5,
          text: 'Уделяю внимание мелочам',
          img: 'search.png',
        },
        {
          id: 6,
          text: 'Делаю всё быстро',
          img: 'fast-time.png',
        },
        {
          id: 7,
          text: 'Эмпат в общении',
          img: 'handshake.png',
        },
        {
          id: 8,
          text: 'Найду выход из любой ситуации',
          img: 'idea.png',
        },
      ],
    };
  },
};
</script>
