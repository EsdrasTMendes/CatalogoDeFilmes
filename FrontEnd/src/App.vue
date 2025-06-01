<template>
  <div class="min-h-screen flex flex-col bg-kh-purple-light">
    <AppHeader @navigate-to-search-home="resetToSearchHome" />

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
import AppHeader from './components/AppHeader.vue'; // Corrigido o nome do componente, se o seu era AppHeader.vue
import AppFooter from './components/AppFooter.vue'; // Corrigido o nome do componente, se o seu era AppFooter.vue
import MovieCard from './components/MovieCard.vue';
import SearchMovies from './components/SearchMovies.vue'; // Corrigido o nome do componente, se o seu era SearchMovies.vue
import { searchMovies, getFavoriteMovies } from './services/MovieService'; // Assumindo que você terá getFavoriteMovies

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
        const response = await searchMovies(query); // Sua função de serviço
        console.log("Resposta da API (bruta):", response); // Log para ver a estrutura da resposta completa

        // Verifique a estrutura da sua 'response'.
        // Se 'searchMovies' retorna o objeto de resposta do Axios, os dados estarão em response.data.
        // Se a API aninha os resultados (ex: { page: 1, results: [...] }), seria response.data.results.
        // Ajuste conforme necessário. Vou assumir que response.data é o array de filmes.
        if (response && response.data) {
          // Mapeie os dados se os nomes das propriedades da API forem diferentes dos esperados pelo MovieCard
          // Exemplo: se a API retorna 'title' mas MovieCard espera 'name', ou 'poster_path' vs 'image'
          // Por agora, vou assumir que os nomes são compatíveis ou que seu MovieCard já lida com os nomes da API.
          this.movieList = response.data;
          console.log("Filmes atribuídos a movieList:", this.movieList);
        } else if (response) {
          // Se searchMovies já retorna o array de filmes diretamente (não o objeto Axios inteiro)
          this.movieList = response;
           console.log("Filmes atribuídos a movieList (resposta direta):", this.movieList);
        } else {
          // Se a resposta for inesperada ou vazia
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
        // Supondo que você tenha uma função getFavoriteMovies em MovieService
        const response = await getFavoriteMovies();
        console.log("Resposta da API de Favoritos:", response);

        if (response && response.data) {
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
/* Garante que o body ocupe a altura total e o App também */
html, body, #app {
  height: 100%;
  margin: 0;
}
/* A classe bg-kh-purple-light já deve estar no seu style.css global para o body */
/* Adicione aqui quaisquer estilos globais necessários ou no seu assets/style.css */
</style>
