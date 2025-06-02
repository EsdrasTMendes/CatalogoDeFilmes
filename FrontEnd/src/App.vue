<template>
  <div class="min-h-screen flex flex-col bg-kh-purple-light">
    <AppHeader /> <main class="flex-grow flex">
      <router-view /> </main>
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
  // A lógica de currentView, movieList, isLoading, handleSearch, handleListFavorites
  // será movida para os componentes de view específicos (SearchMoviesView.vue, FavoritesView.vue)
};
</script>

<style>
/* Seus estilos globais */
html, body, #app {
  height: 100%;
  margin: 0;
}
</style>
