<template>
  <header class="py-4 shadow-sm bg-white">
    <div class="container mx-auto px-4 flex justify-between items-center h-12">
      <button
        @click="navigateToListFavorites" class="flex items-center p-2 rounded-md text-kh-purple hover:text-[#eb4b00] hover:bg-kh-purple-light transition-colors duration-300 focus:outline-none group"
        title="Listar filmes favoritos"
        aria-label="Listar filmes favoritos"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 1.25 29.1 22" fill="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform duration-300">
          <path d="M26.5093 6.36596C27.3828 6.50228 28.2442 6.65299 29.0933 6.8181L23.9531 23.1954C21.4854 21.8085 18.18 20.9639 14.5485 20.9639C10.9171 20.9639 7.60784 21.8085 5.14139 23.1954L0 6.81937C0.850791 6.65426 1.7138 6.50355 2.58902 6.36723C3.93217 9.9945 5.56721 12.1218 7.33239 12.1218C9.23403 12.1218 10.9904 9.64777 12.3866 5.48582C12.8099 4.2272 13.2003 2.81109 13.5541 1.2629C13.8826 1.2629 14.2128 1.26078 14.5447 1.25655C14.8766 1.25232 15.2068 1.25443 15.5354 1.2629C15.853 2.68955 16.2426 4.09901 16.7029 5.48582C18.1029 9.64777 19.8554 12.1218 21.7571 12.1218C23.5273 12.1218 25.1649 9.99449 26.5093 6.36596Z"/>
        </svg>
        <span class="ml-2 font-medium group-hover:scale-105 transition-transform duration-300">Listar favoritos</span>
      </button>

            <div class="text-center">
        <span
          @click="navigateToSearchHome"
          @keydown.enter="navigateToSearchHome"
          @keydown.space.prevent="navigateToSearchHome"
          role="link"
          tabindex="0"
          class="text-xl font-semibold text-kh-purple select-none hover:text-[#eb4b00] transition-colors cursor-pointer focus:outline-none focus:ring-2 focus:ring-kh-purple rounded"
          aria-label="Ir para a página inicial de busca do catálogo de filmes"
        >
          Catálogo de Filmes
        </span>
      </div>

      <button
        @click="navigateToSearchHome" class="flex items-center p-2 rounded-md text-kh-purple hover:text-[#eb4b00] hover:bg-kh-purple-light transition-colors duration-300 focus:outline-none group"
        title="Buscar filmes"
        aria-label="Ir para a busca de filmes"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform duration-300">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
        <span class="ml-2 font-medium group-hover:scale-105 transition-transform duration-300">Buscar filmes</span>
      </button>
    </div>
  </header>
</template>

<script>
export default {
  name: 'AppHeader',
  methods: {
    navigateToSearchHome() {
      this.$router.push({ path: '/', query: { refresh: Date.now() } });
    },
    navigateToListFavorites() {
      if (this.$route.path !== '/favorites') {
        this.$router.push('/favorites');
      }
    }
  }
};
</script>
