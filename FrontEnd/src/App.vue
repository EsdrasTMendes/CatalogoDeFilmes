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
import AppHeader from './components/AppHeader.vue';
import AppFooter from './components/AppFooter.vue';
import MovieCard from './components/MovieCard.vue';
import SearchMovies from './components/SearchMovies.vue'; // Novo componente de view
// import { movies as mockMovies } from './mock/movies'; // Não usaremos mock inicial agora

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
      movieList: [], // Começa com lista vazia
      currentView: 'search', // 'search' ou 'list'
      isLoading: false, // Para feedback de carregamento
    };
  },
  computed: {
    showSearchScreen() {
      // Mostra a tela de busca se a view for 'search'
      // OU se não houver filmes e não estiver carregando (após uma busca sem resultados)
      // A lógica inicial é sempre mostrar a tela de busca.
      return this.currentView === 'search';
    }
  },
  methods: {
    resetToSearchHome() {
      this.currentView = 'search';
      this.movieList = []; // Limpa a lista de filmes ao voltar para a busca
      this.isLoading = false;
    },
    async handleSearch(query) {
      console.log("App.vue: Realizar busca por:", query);
      this.isLoading = true;
      this.currentView = 'list'; // Muda para a view de lista para mostrar carregando ou resultados
      this.movieList = []; // Limpa resultados anteriores

      // SIMULAÇÃO DE CHAMADA API
      await new Promise(resolve => setTimeout(resolve, 1500)); // Simula delay da rede

      // Aqui você faria a chamada real à API:
      // try {
      //   const response = await fetch(`/api/movies/search?q=${query}`);
      //   if (!response.ok) throw new Error('Falha na busca');
      //   const data = await response.json();
      //   this.movieList = data;
      // } catch (error) {
      //   console.error("Erro na busca:", error);
      //   this.movieList = []; // Garante que a lista está vazia em caso de erro
      // } finally {
      //   this.isLoading = false;
      // }

      // Simulação de resultados (substitua pela chamada API real)
      if (query.toLowerCase().includes("vingadores")) {
         this.movieList = [ // Exemplo de mock de retorno
            { id: 1, title: 'Os Vingadores: The Avengers', poster_path: 'https://image.tmdb.org/t/p/w500/uSAPS6fG24n2T0gH2Hq27h69g2R.jpg', overview: 'Loki, o irmão de Thor, ganha acesso ao poder ilimitado do cubo cósmico...', release_date: '2012-04-25' },
            { id: 2, title: 'Vingadores: Era de Ultron', poster_path: 'https://image.tmdb.org/t/p/w500/vGIIhfn3QyPbogK00N3Qh4iHULH.jpg', overview: 'Quando Tony Stark tenta reiniciar um programa de manutenção de paz...', release_date: '2015-04-23' }
          ];
      } else if (query.toLowerCase().includes("nada")) {
        this.movieList = [];
      } else {
         this.movieList = [
            { id: 3, title: 'Filme Genérico Encontrado', poster_path: 'https://via.placeholder.com/500x750.png?text=Poster+Filme', overview: 'Uma breve descrição para um filme genérico que foi encontrado.', release_date: '2025-01-01' }
          ];
      }
      this.isLoading = false;
    },
    handleListFavorites() {
      console.log("App.vue: Navegar para a página de favoritos!");
      this.isLoading = true;
      this.currentView = 'list'; // Muda para a view de lista
      this.movieList = [];

      // SIMULAÇÃO DE CHAMADA API PARA FAVORITOS
      setTimeout(() => {
        // this.movieList = [ ...array de filmes favoritos mockados... ];
        console.log("Favoritos seriam carregados aqui.");
        // Exemplo se não houver favoritos:
        this.movieList = []; // Se não houver favoritos, mostrará "Nenhum filme encontrado"
        this.isLoading = false;
      }, 1000);
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
