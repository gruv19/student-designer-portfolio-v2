<template>
  <input
    :type="type"
    :name="name"
    class="input"
    :class="modifier ? `input--${modifier}` : ''"
    @input="handleInput"
    :placeholder="plcHolder"
    :value="modelValue"
    autocomplete="off"
  >
</template>

<script>
export default {
  name: 'BaseInput',
  props: {
    name: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      required: true,
      default: 'text',
    },
    modifier: {
      type: String,
      default: '',
    },
    modelValue: {
      required: true,
    },
    plcHolder: {
      required: true,
    },
  },
  methods: {
    handleInput(e) {
      this.$emit('update:modelValue', e.target.value);
    },
  },
};
</script>
