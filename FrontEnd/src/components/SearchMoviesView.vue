<template>
  <div class="w-full">
    <SearchMovies
      v-if="showSearchInterface"
      @search-initiated="handleSearch"
      @list-favorites-requested="navigateToListFavoritesPage"
    />

    <div v-if="!showSearchInterface && isLoading" class="text-center py-12 flex justify-center items-center">
      <div class="w-12 h-12 border-4 border-kh-purple rounded-full animate-spin" role="status" aria-label="Carregando filmes"></div>
    </div>

    <div v-if="!showSearchInterface && movieList.length > 0 && !isLoading" class="container mx-auto p-6 md:p-8 w-full">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
        <MovieCard
          v-for="movie in movieList"
          :key="movie.id"
          :movie="movie"
          :is-favorite-context="false"
        />
      </div>
    </div>

    <div v-if="!showSearchInterface && movieList.length === 0 && !isLoading" class="container mx-auto p-6 md:p-8 w-full text-center py-12">
      <p class="text-xl text-kh-gray-medium">Nenhum filme encontrado para sua busca.</p>
      <button @click="showSearchInterface = true; movieList = []" class="mt-4 text-kh-purple hover:underline">
        Fazer uma nova busca
      </button>
    </div>
  </div>
</template>

<script>
import SearchMovies from '../components/SearchMovies.vue';
import MovieCard from '../components/MovieCard.vue';
import { searchMovies as fetchMoviesByQuery } from '../services/MovieService';

export default {
  name: 'SearchMoviesView',
  mounted() {
    if (this.$route.query.refresh) {
      this.$router.replace({ path: '/', query: {} });
    }},
  components: {
    SearchMovies,
    MovieCard,
  },
  data() {
    return {
      movieList: [],
      isLoading: false,
      showSearchInterface: true,
    };
  },
  methods: {
    async handleSearch(query) {
      this.isLoading = true;
      this.showSearchInterface = false;
      this.movieList = [];
      try {
        const movies = await fetchMoviesByQuery(query);
        this.movieList = movies || [];
      } catch (error) {
        console.error("Erro na busca:", error);
        this.movieList = [];
      } finally {
        this.isLoading = false;
      }
    },
    navigateToListFavoritesPage() {
        this.$router.push('/favorites');
    }
  },
};
</script>
