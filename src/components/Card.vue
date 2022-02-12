<template>
  <article class="card">
      <img src="https://imgholder.ru/720x480/8270DE/F5F5F5.jpg&text=work_card&font=arial" alt="Изображение работы" class="card__image">
      <h3 class="card__title">Slonum</h3>
      <!-- <a href="/work_id" class="button">Посмотреть</a> -->
      <Button link="/work_id" text="Посмотреть" />
      <p class="card__subtitle">Тестовое задание</p>
      <p class="card__task">
        Задача: Landing page для участия в олимпиаде по математике, учиттывая ТЗ.
      </p>
      <a href="http://zhenyagru.tilda.ws/rynzhukfolio" class="card__link">Открыть в браузере</a>
    </article>
</template>

<script>
import Button from './Button.vue';

export default {
  name: 'Card',
  components: {
    Button,
  },
};
</script>
