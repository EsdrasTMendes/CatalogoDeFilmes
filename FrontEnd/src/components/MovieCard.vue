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
import CardTitle from './CardTitle.vue';     // Ajuste o caminho se necessário
import CardImage from './CardImage.vue';     // Ajuste o caminho se necessário
import CardActions from './CardActions.vue';   // Ajuste o caminho se necessário
import CardBack from './CardBack.vue';       // Ajuste o caminho se necessário

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
      isFavorite: false,  // Gerenciado aqui, passado como prop para CardActions
      currentRating: 0, // Gerenciado aqui, passado como prop para CardActions
    };
  },
  methods: {
    toggleFlip() {
      this.isFlipped = !this.isFlipped;
    },
    handleToggleFavorite() {
      this.isFavorite = !this.isFavorite;
      if (!this.isFavorite) {
        this.currentRating = 0;
        console.log(`Filme "${this.movie.title}" removido dos favoritos (MovieCard).`);
      } else {
        console.log(`Filme "${this.movie.title}" adicionado aos favoritos (MovieCard).`);
      }
      // Futuramente: this.$emit('update-favorite-status', { id: this.movie.id, isFavorite: this.isFavorite });
    },
    handleRateMovie(rating) {
      if (!this.isFavorite) return;
      this.currentRating = rating;
      console.log(`Filme "${this.movie.title}" avaliado com ${rating} estrelas (MovieCard).`);
      // Futuramente: this.$emit('update-rating', { id: this.movie.id, rating: this.currentRating });
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
  /* As classes de rounded-lg e overflow-hidden estão nos componentes filhos (CardFront e CardBack em suas raízes) */
}

/* .card-front já tem bg-kh-card-bg em sua raiz no template do MovieCard.vue */
/* .card-front { } */

.card-back {
  /* O componente CardBack.vue já tem bg-kh-card-bg em sua raiz.
     A rotação é aplicada aqui para o efeito de flip. */
  transform: rotateY(180deg);
}
</style>
