<template>
  <div class="w-full">
    <FavoritesFilterSubHeader
      :genres="genres"
      @genre-selected="handleGenreFilterChange"
      v-if="genres.length > 0"
    />
    <div class="container mx-auto p-6 md:p-8">
      <div v-if="isLoading" class="text-center py-12">
        <p class="text-xl text-kh-gray-medium">Carregando seus filmes favoritos...</p>
        </div>
      <div v-else-if="favoriteMovies.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
        <MovieCard
          v-for="movie in favoriteMovies"
          :key="movie.id"
          :movie="movie"
          :is-favorite-context="true" />
      </div>
      <div v-else class="text-center py-12">
        <p v-if="selectedGenreId" class="text-xl text-kh-gray-medium">
          Você não tem filmes favoritos para o gênero selecionado.
        </p>
        <p v-else class="text-xl text-kh-gray-medium">
          Você ainda não adicionou nenhum filme aos favoritos. 😕
        </p>
        <router-link to="/" class="mt-4 inline-block text-kh-purple hover:text-[#eb4b00] hover:underline">
          Buscar filmes para favoritar
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import MovieCard from '../components/MovieCard.vue';
import FavoritesFilterSubHeader from '../components/FavoritesFilterSubHeader.vue';
import { getFavoriteMovies, getAllGenres } from '../services/MovieService'; // Assumindo que getAllGenres busca os gêneros

export default {
  name: 'FavoritesView',
  components: {
    MovieCard,
    FavoritesFilterSubHeader,
  },
  data() {
    return {
      favoriteMovies: [],
      genres: [],
      selectedGenreId: null,
      isLoading: false,
      isLoadingGenres: false,
    };
  },
  async created() {
    this.isLoadingGenres = true;
    try {
      const genresData = await getAllGenres();
      this.genres = genresData || [];
    } catch (error) {
      console.error("Erro ao buscar gêneros:", error);
      this.genres = [];
    } finally {
      this.isLoadingGenres = false;
    }
    this.fetchUserFavoriteMovies();
  },
  methods: {
    async fetchUserFavoriteMovies() {
      this.isLoading = true;
      try {
        const moviesData = await getFavoriteMovies();
        console.log("Filmes favoritos recebidos:", moviesData);
        this.favoriteMovies = moviesData.data;
      } catch (error) {
        console.error("Erro ao buscar filmes favoritos:", error);
        this.favoriteMovies = [];
      } finally {
        this.isLoading = false;
      }
    },
    handleGenreFilterChange(genreId) {
      this.isLoading = true;
      this.selectedGenreId = genreId;
      try {
        if (genreId) {
          this.favoriteMovies = this.favoriteMovies.filter(movie => movie.genre_ids.includes(genreId));
          console.log("Filmes filtrados por gênero:", this.favoriteMovies);
        } else {
          this.fetchUserFavoriteMovies();
        }
      } catch (error) {
        console.error("Erro ao filtrar filmes favoritos:", error);
      } finally {
        this.isLoading = false;
      }
    }
  }
};
</script>
