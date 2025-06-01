<template>
  <div class="min-h-screen"> <header class="py-8 shadow-sm bg-white">
      <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-kh-purple text-center">Meu Catálogo de Filmes</h1>
      </div>
    </header>

    <main class="container mx-auto p-6 md:p-8">
      <div v-if="movieList.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
        <MovieCard
          v-for="movie in movieList"
          :key="movie.id"
          :movie="movie"
        />
      </div>
      <div v-else class="text-center py-12">
        <p class="text-xl text-kh-gray-medium">Nenhum filme encontrado.</p>
      </div>
    </main>

    <footer class="py-6 mt-10 text-center border-t border-gray-300">
      <p class="text-sm text-kh-gray-medium">&copy; {{ new Date().getFullYear() }} Catálogo de Filmes. Inspirado por KingHost.</p>
    </footer>
  </div>
</template>

<script>
import MovieCard from './components/MovieCard.vue';
import { movies } from './mock/movies'; // Seu mock

export default {
  name: 'App',
  components: {
    MovieCard
  },
  data() {
    return {
      movieList: movies
    }
  }
}
</script>

<style>
</style>
