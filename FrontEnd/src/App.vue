<template>
  <div class="min-h-screen flex flex-col bg-kh-purple-light">
    <AppHeader
  @navigate-to-search-home="resetToSearchHome"
  @list-favorites-requested="handleListFavorites" />

    <main class="flex-grow flex">
      <SearchMovies
        v-if="showSearchScreen"
        @search-initiated="handleSearch"
        @list-favorites-requested="handleListFavorites"
        class="w-full"
      />

      <div v-if="!showSearchScreen && movieList.length > 0" class="container mx-auto p-6 md:p-8 w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
          <MovieCard
            v-for="movie in movieList"
            :key="movie.id"
            :movie="movie"
          />
        </div>
      </div>

      <div v-if="!showSearchScreen && movieList.length === 0 && !isLoading" class="container mx-auto p-6 md:p-8 w-full text-center py-12">
        <p class="text-xl text-kh-gray-medium">Nenhum filme encontrado para sua busca.</p>
        <button @click="resetToSearchHome" class="mt-4 text-kh-purple hover:underline">
            Fazer uma nova busca
        </button>
      </div>

      <div v-if="isLoading" class="container mx-auto p-6 md:p-8 w-full text-center py-12">
        <p class="text-xl text-kh-gray-medium">Carregando filmes...</p> {/* Adicionar um spinner aqui seria legal */}
      </div>
    </main>

    <AppFooter />
  </div>
</template>

<script>
import AppHeader from './components/AppHeader.vue';
import AppFooter from './components/AppFooter.vue';
import MovieCard from './components/MovieCard.vue';
import SearchMovies from './components/SearchMovies.vue';
import { searchMovies, getFavoriteMovies } from './services/MovieService';

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
    MovieCard,
    SearchMovies,
  },
  data() {
    return {
      movieList: [],
      currentView: 'search',
      isLoading: false,
      isFavoriteMovie: false,
    };
  },
  computed: {
    showSearchScreen() {
      return this.currentView === 'search';
    }
  },
  methods: {
    resetToSearchHome() {
      this.currentView = 'search';
      this.movieList = [];
      this.isLoading = false;
    },
    async handleSearch(query) {
      console.log("App.vue: Realizar busca por:", query);
      this.isLoading = true;
      this.currentView = 'list';
      this.movieList = [];

      try {
        const response = await searchMovies(query);
        console.log("Resposta da API (bruta):", response);

        if (response && response.data) {
          this.movieList = response.data;
          console.log("Filmes atribuídos a movieList:", this.movieList);
        } else if (response) {
          this.movieList = response;
          console.log("Filmes atribuídos a movieList (resposta direta):", this.movieList);
        } else {
          this.movieList = [];
          console.warn("Resposta da API não continha os dados esperados ou estava vazia.");
        }

      } catch (error) {
        console.error("Erro na busca:", error.response ? error.response.data : error.message, error);
        this.movieList = [];
      } finally {
        this.isLoading = false;
      }
    },
    async handleListFavorites() {
      console.log("App.vue: Listar favoritos!");
      this.isLoading = true;
      this.currentView = 'list';
      this.movieList = [];

      try {
        const response = await getFavoriteMovies();
        console.log("Resposta da API de Favoritos:", response);

        if (response && response.data) {
        console.log("Resposta da API de Favoritos, pós if:", response);
          this.movieList = response.data;
        } else if (response) {
          this.movieList = response;
        } else {
          this.movieList = [];
        }
      } catch (error) {
        console.error("Erro ao buscar favoritos:", error.response ? error.response.data : error.message, error);
        this.movieList = [];
      } finally {
        this.isLoading = false;
      }
    }
  }
};
</script>

<style>
html, body, #app {
  height: 100%;
  margin: 0;
}
</style>
