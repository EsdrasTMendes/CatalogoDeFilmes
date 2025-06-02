<template>
  <div class="bg-white py-3 px-4 shadow-md sticky top-0 z-10"> <div class="container mx-auto flex flex-col sm:flex-row items-center justify-center gap-4">
      <p class="text-md text-kh-gray-dark font-medium">
        Filtre os seus favoritos por Gênero:
      </p>
      <div class="relative">
        <select
          v-model="selectedGenreId"
          @change="emitGenreChange"
          class="appearance-none w-full sm:w-64 bg-gray-50 border border-gray-300 text-kh-gray-dark text-sm rounded-lg focus:ring-kh-purple focus:border-kh-purple block p-2.5 hover:border-kh-purple transition-colors cursor-pointer"
          aria-label="Selecionar gênero para filtrar filmes favoritos"
        >
          <option :value="null">Todos os Gêneros</option>
          <option v-for="genre in genres" :key="genre.id" :value="genre.id">
            {{ genre.name }}
          </option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.516 7.548c.436-.446 1.043-.48 1.576 0L10 10.405l2.908-2.857c.533-.48 1.14-.446 1.576 0 .436.445.408 1.197 0 1.615l-3.712 3.648c-.27.273-.628.406-.976.406s-.706-.133-.976-.406L5.516 9.163c-.408-.418-.436-1.17 0-1.615z"/></svg>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FavoritesFilterSubHeader',
  props: {
    genres: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  emits: ['genre-selected'],
  data() {
    return {
      selectedGenreId: null // Representa "Todos os Gêneros" inicialmente
    };
  },
  methods: {
    emitGenreChange() {
      this.$emit('genre-selected', this.selectedGenreId);
    }
  },
  watch: {
    // Se a rota mudar e este componente for reutilizado,
    // pode ser útil resetar o select se necessário,
    // mas geralmente a navegação para /favorites o recriará ou a view pai controlará o estado.
    '$route'() {
      // Exemplo: se voltarmos para /favorites sem um gênero específico na URL, resetar.
      // Isso depende de como você quer que o filtro persista ou não.
      // Por ora, o FavoritesView.vue controlará o filtro.
    }
  }
};
</script>

<style scoped>
/* Para um <select> mais "bonitinho", você pode precisar de mais CSS
   ou usar uma biblioteca de componentes UI que ofereça dropdowns estilizados.
   As classes do Tailwind acima dão uma aparência limpa e funcional.
   A classe "appearance-none" remove o estilo padrão do navegador. */
select {
  background-image: none; /* Garante que a seta customizada do div funcione bem */
}
</style>
