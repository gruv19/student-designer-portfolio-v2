<template>
  <a
    v-if="link"
    class="button"
    :href="link"
    :class="modifier ? `button--${modifier}` : '' "
  >{{ text }}</a>
  <button
    v-else
    class="button"
    :type="type"
    :class="modifier ? `button--${modifier}` : '' "
  >{{ text }}</button>
</template>

<script>
export default {
  name: 'Button',
  props: {
    link: {
      type: String,
    },
    text: {
      type: String,
      required: true,
    },
    modifier: {
      type: String,
    },
    type: {
      type: String,
      default: 'submit',
    },
  },
};
</script>
