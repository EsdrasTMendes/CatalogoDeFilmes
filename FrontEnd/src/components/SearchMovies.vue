<template>
  <div class="search-movies-container flex flex-col items-center gap-2 justify-center text-center px-4 py-8 md:py-16">
    <div class="flex items-center gap-4 mb-2">
      <div class="mb-7">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" fill="currentColor" class="w-18 h-18 text-kh-purple">
          <path d="M26.5093 6.36596C27.3828 6.50228 28.2442 6.65299 29.0933 6.8181L23.9531 23.1954C21.4854 21.8085 18.18 20.9639 14.5485 20.9639C10.9171 20.9639 7.60784 21.8085 5.14139 23.1954L0 6.81937C0.850791 6.65426 1.7138 6.50355 2.58902 6.36723C3.93217 9.9945 5.56721 12.1218 7.33239 12.1218C9.23403 12.1218 10.9904 9.64777 12.3866 5.48582C12.8099 4.2272 13.2003 2.81109 13.5541 1.2629C13.8826 1.2629 14.2128 1.26078 14.5447 1.25655C14.8766 1.25232 15.2068 1.25443 15.5354 1.2629C15.853 2.68955 16.2426 4.09901 16.7029 5.48582C18.1029 9.64777 19.8554 12.1218 21.7571 12.1218C23.5273 12.1218 25.1649 9.99449 26.5093 6.36596Z"/>
        </svg>
      </div>
      <div>
          <h2 class="text-2xl md:text-3xl font-semibold text-kh-gray-dark mb-6">
            Bem-vindo ao Catálogo de Filmes!
          </h2>
      </div>
    </div>

    <p class="text-lg text-kh-gray-medium mb-5">
      Digite o nome do filme que você procura:
    </p>

    <form @submit.prevent="submitSearch" class="w-full max-w-lg flex items-center shadow-lg rounded-lg overflow-hidden">
      <input
        type="search"
        v-model="searchQuery"
        placeholder="Ex: Interestelar, Vingadores, etc..."
        class="px-4 py-3 border-0 text-base text-kh-gray-dark focus:ring-2 focus:ring-kh-purple flex-grow min-w-0"
        ref="searchInput"
        aria-label="Campo de busca de filmes"
      />
      <button
        type="submit"
        class="bg-kh-purple text-white px-5 py-3 hover:bg-opacity-80 transition-colors"
        aria-label="Buscar"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
      </button>
    </form>

    <div class="mt-12">
      <button
        @click="listFavorites"
        class="bg-transparent hover:bg-kh-purple-light text-kh-purple font-semibold hover:text-opacity-90 py-3 px-6 border border-kh-purple hover:border-transparent rounded-lg transition-all duration-300"
      >
        Listar Meus Filmes Favoritos
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SearchMovies',
  emits: ['search-initiated', 'list-favorites-requested'],
  data() {
    return {
      searchQuery: '',
    };
  },
  mounted() {
    // Foca no campo de busca ao montar o componente
    this.$refs.searchInput?.focus();
  },
  methods: {
    submitSearch() {
      if (this.searchQuery.trim()) {
        this.$emit('search-initiated', this.searchQuery.trim());
        // this.searchQuery = ''; // Opcional: limpar após a busca
      } else {
        this.$refs.searchInput?.focus(); // Foca de novo se tentar buscar vazio
      }
    },
    listFavorites() {
      this.$emit('list-favorites-requested');
    },
  },
};
</script>

<style scoped>
.search-movies-container {
  /* Para ocupar o espaço disponível na área de <main> do App.vue */
  /* Se App.vue <main> tem flex-grow, este componente pode ter width e height 100% */
  width: 100%;
  /* min-height: calc(100vh - altura_do_header - altura_do_footer); */ /* Se quiser que preencha a tela verticalmente */
}

input[type="search"] {
  /* Remove o 'x' padrão do campo de busca em alguns navegadores */
  -webkit-appearance: none;
  appearance: none;
}
input[type="search"]::-webkit-search-decoration,
input[type="search"]::-webkit-search-cancel-button,
input[type="search"]::-webkit-search-results-button,
input[type="search"]::-webkit-search-results-decoration {
  -webkit-appearance:none;
}
</style>
