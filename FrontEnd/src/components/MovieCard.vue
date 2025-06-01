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
      <div class="card-face card-front bg-white flex flex-col overflow-hidden rounded-lg">
        <div class="flex-grow h-0 min-h-0 p-3 bg-black flex items-center justify-center">
          <img
            class="max-w-full max-h-full object-contain"
            :src="movie.poster_path"
            :alt="`Capa do filme ${movie.title}`"
          />
        </div>
        <div class="p-4 border-t border-gray-200 flex-shrink-0">
          <p class="text-lg font-semibold text-kh-purple truncate" :title="movie.nome">
            {{ movie.title }}
          </p>
        </div>
      </div>

      <div class="card-face card-back bg-white p-4 flex flex-col overflow-hidden rounded-lg">
        <h4 class="text-md font-semibold text-kh-purple mb-2 flex-shrink-0 text-center" :title="movie.nome">
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
    };
  },
  methods: {
    toggleFlip() {
      this.isFlipped = !this.isFlipped;
    },
  },
};
</script>

<style scoped>
/* Container principal que terá a perspectiva e o efeito de flutuar */
.movie-card-container {
  perspective: 1200px; /* Profundidade da perspectiva para o efeito 3D */
  /* Efeito flutuante no hover do container */
  transition: transform 0.3s ease-in-out;
}
.movie-card-container:hover {
  transform: translateY(-10px); /* Ajuste o valor para mais ou menos "flutuação" */
}

/* Elemento interno que realmente gira */
.movie-card-inner {
  transform-style: preserve-3d; /* Mantém os elementos filhos no espaço 3D */
  /* A sombra já é aplicada por classes Tailwind, e o group-hover:shadow-xl intensifica */
}

.movie-card-inner.is-flipped {
  transform: rotateY(180deg); /* Efeito de girar */
}

/* Estilo comum para ambas as faces do card */
.card-face {
  position: absolute; /* Sobrepõe as faces */
  width: 100%;
  height: 100%;
  backface-visibility: hidden; /* Esconde a face que está "atrás" */
  /* As classes de bg, overflow e rounded já estão no template */
}

/* A frente já está visível por padrão */
.card-front {
  /* z-index: 2; Opcional, se houver problemas de sobreposição durante a animação */
}

/* O verso começa girado */
.card-back {
  transform: rotateY(180deg);
  /* z-index: 1; Opcional */
}

/* Estilização da barra de rolagem para a descrição no verso (opcional) */
.description-scroll {
  scrollbar-width: thin; /* "auto" ou "thin" */
  scrollbar-color: var(--color-kh-purple) transparent; /* Cor do thumb e do track */
}
/* Para navegadores baseados em WebKit (Chrome, Safari, Edge) */
.description-scroll::-webkit-scrollbar {
  width: 6px;
}
.description-scroll::-webkit-scrollbar-track {
  background: transparent; /* Ou var(--color-kh-purple-light) se quiser um fundo visível */
  border-radius: 3px;
}
.description-scroll::-webkit-scrollbar-thumb {
  background-color: var(--color-kh-purple);
  border-radius: 3px;
}
</style>
