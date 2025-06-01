<template>
  <div
    class="movie-card-container group w-full h-96 rounded-lg cursor-pointer"
    @click="toggleFlip"
    role="button"
    tabindex="0"
    @keydown.enter="toggleFlip"
    @keydown.space="toggleFlip"
    :aria-label="`Ver detalhes de ${movie.title}`"
    :aria-expanded="isFlipped.toString()"
  >
    <div
      class="movie-card-inner relative w-full h-full shadow-md group-hover:shadow-xl rounded-lg transition-all duration-700 ease-in-out"
      :class="{ 'is-flipped': isFlipped }"
    >
      <div class="card-face card-front bg-kh-card-bg flex flex-col overflow-hidden rounded-lg h-full">
        <CardTitle :title="movie.title" />
        <CardImage :posterPath="movie.poster_path" :altText="movie.title" />
        <CardActions
          :isFavorite="isFavorite"
          :currentRating="currentRating"
          @toggle-favorite="handleToggleFavorite"
          @rate-movie="handleRateMovie"
        />
      </div>

      <CardBack
        :title="movie.title"
        :overview="movie.overview"
        :releaseDate="movie.release_date"
      />
    </div>
  </div>
</template>

<script>
import CardTitle from './CardTitle.vue';
import CardImage from './CardImage.vue';
import CardActions from './CardActions.vue';
import CardBack from './CardBack.vue';
import { postFavoriteMovie, removeFavoriteMovie, rateFavoriteMovie } from '../services/MovieService';

export default {
  name: 'MovieCard',
  components: {
    CardTitle,
    CardImage,
    CardActions,
    CardBack,
  },
  props: {
    movie: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isFlipped: false,
      isFavorite: (this.movie.is_favorite == 1 ? true : false), // Verifica se o filme é favorito
      currentRating: this.movie.rating || 0, // Se for favorito, inicia com 0, senão null
    };
  },
  methods: {
    toggleFlip() {
      this.isFlipped = !this.isFlipped;
    },
    async handleToggleFavorite() {
      const response = await (this.isFavorite ? removeFavoriteMovie(this.movie.id) : postFavoriteMovie(this.movie));
      console.log("Resposta do servidor:", response); // Pensar algum elemento visual para feedback
      if (response.status === 201 || response.status === 204) {
        this.isFavorite = !this.isFavorite;
        console.log(`Filme "${this.movie.title}" ${this.isFavorite ? 'adicionado' : 'removido'} aos favoritos (MovieCard).`);
        if (this.isFavorite) {
          this.currentRating = 0;
        }
      } else {
        console.error(`Erro ao ${this.isFavorite ? 'remover' : 'adicionar'} filme "${this.movie.title}" aos favoritos.`);
      }
    },

    async handleRateMovie(rating) {
      const response = await rateFavoriteMovie(this.movie.id, rating);
      console.log("Resposta do servidor ao avaliar filme:", response); // Pensar algum elemento visual para feedback
      if (!this.isFavorite) return;
      this.currentRating = rating;
    },
  },
};
</script>

<style scoped>
.movie-card-container {
  perspective: 1200px;
  transition: transform 0.3s ease-in-out;
}
.movie-card-container:hover {
  transform: translateY(-10px);
}

.movie-card-inner {
  transform-style: preserve-3d;
}
.movie-card-inner.is-flipped {
  transform: rotateY(180deg);
}

.card-face {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
}


.card-back {
  transform: rotateY(180deg);
}
</style>
