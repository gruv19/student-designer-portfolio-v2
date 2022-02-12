<template>
  <a class="button" :href="link">{{ text }}</a>
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
  },
};
</script>
