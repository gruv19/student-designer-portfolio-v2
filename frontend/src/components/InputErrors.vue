<template>
  <div class="input-errors">
    {{ error.$message }}
  </div>
</template>

<script>
export default {
  name: 'InputErrors',
  props: {
    error: {
      required: true,
    },
  },
};
</script>
