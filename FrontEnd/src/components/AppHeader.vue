<template>
  <header class="py-4 shadow-sm bg-white">
    <div class="container mx-auto px-4 flex justify-between items-center h-12">

      <button
        @click="navigateToSearchHome"
        class="p-2 rounded-full text-kh-purple hover:text-[#eb4b00] hover:bg-kh-purple-light transition-transform duration-300 hover:scale-110 focus:outline-none"
        title="Nova Busca / Início"
        aria-label="Voltar para a tela de busca inicial"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 1.25 29.1 22" fill="currentColor" class="w-6 h-6">
          <path d="M26.5093 6.36596C27.3828 6.50228 28.2442 6.65299 29.0933 6.8181L23.9531 23.1954C21.4854 21.8085 18.18 20.9639 14.5485 20.9639C10.9171 20.9639 7.60784 21.8085 5.14139 23.1954L0 6.81937C0.850791 6.65426 1.7138 6.50355 2.58902 6.36723C3.93217 9.9945 5.56721 12.1218 7.33239 12.1218C9.23403 12.1218 10.9904 9.64777 12.3866 5.48582C12.8099 4.2272 13.2003 2.81109 13.5541 1.2629C13.8826 1.2629 14.2128 1.26078 14.5447 1.25655C14.8766 1.25232 15.2068 1.25443 15.5354 1.2629C15.853 2.68955 16.2426 4.09901 16.7029 5.48582C18.1029 9.64777 19.8554 12.1218 21.7571 12.1218C23.5273 12.1218 25.1649 9.99449 26.5093 6.36596Z"/>
        </svg>
      </button>

      <div class="text-center">
        <span class="text-xl font-semibold text-kh-purple select-none">
          Catálogo de Filmes
        </span>
      </div>

      <button
        @click="navigateToSearchHome"
        class="p-2 rounded-full text-kh-purple hover:text-[#eb4b00] hover:bg-kh-purple-light transition-transform duration-300 hover:scale-110 focus:outline-none"
        title="Buscar filmes"
        aria-label="Ir para a busca de filmes"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
      </button>

    </div>
  </header>
</template>

<script>
export default {
  name: 'AppHeader',
  emits: ['navigate-to-search-home'],
  methods: {
    navigateToSearchHome() {
      this.$emit('navigate-to-search-home');
    }
  }
};
</script>

<style scoped>
/* Ajuste o hover:scale-130 para hover:scale-110 ou similar se 130 for muito grande */
/* Adicionei focus:outline-none aos botões para consistência, já que o anel de foco foi removido antes */
</style>
