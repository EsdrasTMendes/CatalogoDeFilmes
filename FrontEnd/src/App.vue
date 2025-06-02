<template>
  <div class="min-h-screen flex flex-col bg-kh-purple-light">
    <AppHeader />
    <main class="flex-grow flex">
      <router-view :key="$route.fullPath" />
    </main>
    <AppFooter />
  </div>
</template>

<script>
import AppHeader from './components/AppHeader.vue';
import AppFooter from './components/AppFooter.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
  },
};
</script>
