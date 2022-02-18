<template>
  <a class="button" :href="link" :class="`button--${modifier}`">{{ text }}</a>
</template>

<script>
export default {
  name: 'Button',
  props: {
    link: {
      type: String,
      required: true,
    },
    text: {
      type: String,
      required: true,
    },
    modifier: {
      type: String,
    },
  },
};
</script>
