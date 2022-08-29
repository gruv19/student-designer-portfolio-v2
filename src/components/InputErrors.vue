<template>
  <div class="input-errors">
    <span class="input-errors__error" v-for="e in errors" :key="e.$uid">
      {{ e.$message }}
    </span>
  </div>
</template>

<script>
export default {
  name: 'InputErrors',
  props: {
    errors: {
      required: true,
    },
  },
};
</script>
