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
      <div class="card-face card-front bg-kh-card-bg flex flex-col overflow-hidden rounded-lg">
        <div class="p-3 text-center flex-shrink-0 border-b border-gray-200">
          <h3 class="text-base font-semibold text-kh-purple" :title="movie.title">
            {{ movie.title }}
          </h3>
        </div>

        <div class="flex-grow h-0 min-h-0 p-2 bg-black flex items-center justify-center">
          <img
            class="max-w-full max-h-full object-contain"
            :src="movie.poster_path"
            :alt="`Capa do filme ${movie.title}`"
          />
        </div>

        <div class="p-2 border-t border-gray-200 flex-shrink-0 flex justify-around items-center">
          <button
            @click.stop="handleToggleFavorite"
            :title="isFavorite ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos'"
            class="p-2 rounded-full hover:bg-kh-purple-light transition-colors focus:outline-none"
            :aria-pressed="isFavorite.toString()"
          >
            <svg v-if="isFavorite" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-kh-purple"> {/* Cor alterada */}
              <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434L10.788 3.21z" clip-rule="evenodd" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-kh-purple transition-colors"> {/* Cor do hover alterada */}
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.31h5.518a.563.563 0 01.32.875l-4.102 3.499a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.101-3.499a.563.563 0 01.32-.875H9.9l.474-.31L11.48 3.5z" />
            </svg>
          </button>

          <div
            class="rating-stars flex items-center"
            :class="{ 'opacity-50 cursor-not-allowed': !isFavorite }"
            @mouseleave="isFavorite ? (hoverRating = 0) : null"
            role="group"
            aria-label="Avaliação do filme"
          >
            <button
              v-for="starIndex in 5"
              :key="starIndex"
              @click.stop="isFavorite ? handleRateMovie(starIndex) : null"
              @mouseenter="isFavorite ? (hoverRating = starIndex) : null"
              :disabled="!isFavorite"
              class="p-0.5 disabled:cursor-not-allowed focus:outline-none"
              :title="isFavorite ? `Avaliar com ${starIndex} estrela(s)` : 'Adicione aos favoritos para poder avaliar'"
              :aria-label="`Avaliar com ${starIndex} estrela(s)`"
              :aria-checked="currentRating === starIndex"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-5 h-5 transition-colors"
                :class="[
                  (hoverRating >= starIndex || (!hoverRating && currentRating >= starIndex)) && isFavorite
                    ? 'text-kh-purple' /* Cor alterada */
                    : 'text-gray-300',
                  isFavorite && !((hoverRating >= starIndex || (!hoverRating && currentRating >= starIndex)))
                    ? 'hover:text-kh-purple' /* Cor do hover alterada */
                    : '',
                ]"
              >
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434L10.788 3.21z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div class="card-face card-back bg-kh-card-bg p-4 flex flex-col overflow-hidden rounded-lg">
        <h4 class="text-md font-semibold text-kh-purple mb-2 flex-shrink-0 text-center" :title="movie.title">
          {{ movie.title }}
        </h4>
        <div class="description-scroll flex-grow overflow-y-auto mb-2 pr-1">
          <p class="text-xs text-kh-gray-medium leading-normal">
            {{ movie.overview }}
          </p>
        </div>
        <div class="mt-auto pt-2 border-t border-gray-200 flex-shrink-0 text-center">
          <span class="text-xs font-medium text-kh-gray-medium">
            Lançamento: {{ movie.release_date }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// O script permanece o mesmo da sua última versão
export default {
  name: 'MovieCard',
  props: {
    movie: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isFlipped: false,
      isFavorite: false,
      currentRating: 0,
      hoverRating: 0,
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
        this.hoverRating = 0;
        console.log(`Filme "${this.movie.title}" removido dos favoritos.`);
      } else {
        console.log(`Filme "${this.movie.title}" adicionado aos favoritos.`);
      }
    },
    handleRateMovie(rating) {
      if (!this.isFavorite) return;
      this.currentRating = rating;
      this.hoverRating = 0;
      console.log(`Filme "${this.movie.title}" avaliado com ${rating} estrelas.`);
    },
  },
};
</script>

<style scoped>
/* Os estilos CSS em <style scoped> permanecem os mesmos da sua última versão */
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
.description-scroll {
  scrollbar-width: thin;
  scrollbar-color: var(--color-kh-purple) transparent; /* Usando a variável CSS */
}
.description-scroll::-webkit-scrollbar {
  width: 6px;
}
.description-scroll::-webkit-scrollbar-track {
  background: transparent;
}
.description-scroll::-webkit-scrollbar-thumb {
  background-color: var(--color-kh-purple); /* Usando a variável CSS */
  border-radius: 3px;
}
</style>
