<template>
  <div class="w-full">
    <FavoritesFilterSubHeader
      :genres="genres"
      @genre-selected="handleGenreFilterChange"
      v-if="genres.length > 0 && allFavoriteMovies.length > 0"
    />
    <div class="container mx-auto p-6 md:p-8">
      <div v-if="isLoading" class="text-center py-12 flex justify-center items-center">
        <div class="w-12 h-12 border-4 border-kh-purple border-t-transparent rounded-full animate-spin" role="status" aria-label="Carregando seus filmes favoritos"></div>
      </div>
      <div v-else-if="favoriteMovies.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
        <MovieCard
          v-for="movie in favoriteMovies"
          :key="movie.id"
          :movie="movie"
          @removed-from-favorites="removeFromList"
        />
      </div>
      <div v-else class="text-center py-12">
        <p v-if="!isLoading && allFavoriteMovies.length === 0" class="text-xl text-kh-gray-medium flex flex-col items-center justify-center gap-2">
          <span class="text-5xl select-none"></span>
          Você ainda não adicionou nenhum filme aos favoritos.
        </p>
        <p v-else-if="selectedGenreId" class="text-xl text-kh-gray-medium">
          Você não tem filmes favoritos para o gênero selecionado.
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
import { getFavoriteMovies, getAllGenres } from '../services/MovieService';

export default {
  name: 'FavoritesView',
  components: {
    MovieCard,
    FavoritesFilterSubHeader,
  },
  data() {
    return {
      allFavoriteMovies: [],
      favoriteMovies: [],
      genres: [],
      selectedGenreId: null,
      isLoading: false,
      isLoadingGenres: false,
    };
  },
  async created() {
    this.isLoadingGenres = true;
    this.isLoading = true;
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
        this.allFavoriteMovies = moviesData.data;
        this.favoriteMovies = [...this.allFavoriteMovies];
      } catch (error) {
        console.error("Erro ao buscar filmes favoritos:", error);
        this.allFavoriteMovies = [];
        this.favoriteMovies = [];
      } finally {
        this.isLoading = false;
      }
    },
    removeFromList(movieId) {
      this.allFavoriteMovies = this.allFavoriteMovies.filter(movie => movie.id !== movieId);
      this.favoriteMovies = this.favoriteMovies.filter(movie => movie.id !== movieId);
    },
    handleGenreFilterChange(genreId) {
      this.selectedGenreId = genreId;
      if (!genreId) {
        this.favoriteMovies = [...this.allFavoriteMovies];
      } else {
        this.favoriteMovies = this.allFavoriteMovies.filter(movie =>
          movie.genre_ids.includes(genreId)
        );
      }
    },
  },
};
</script>
