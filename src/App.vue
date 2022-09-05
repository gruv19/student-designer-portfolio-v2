<template>
  <router-view v-slot="{ Component }">
    <keep-alive :include="['Main']">
      <component :is="Component" />
    </keep-alive>
  </router-view>
  <notifications position="bottom right" />
</template>
<style lang="scss">
@import '@/style/style.scss';
</style>
