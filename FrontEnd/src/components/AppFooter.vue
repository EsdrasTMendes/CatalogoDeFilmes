<template>
  <footer class="py-6 mt-10 border-t border-gray-300 text-center text-sm text-kh-gray-medium">
    <p class="class-footer">
      &copy; {{ new Date().getFullYear() }} - Catálogo de Filmes.
    </p>
    <p class="class-footer flex justify-center items-center gap-1 mt-1">
      Inspirado por KingHost
      <img src="/crown.svg" alt="Coroa KingHost" class="w-4 h-4 opacity-70" />
    </p>
    <p class="class-footer">
      Desenvolvido por
      <a
        href="https://www.linkedin.com/in/esdrast/"
        class="text-kh-purple hover:underline hover:text-[#eb4b00]"
      >
        Esdras Tenório Mendes
      </a>.
    </p>
  </footer>
</template>

<script>
export default {
  name: 'AppFooter',
};
</script>

<style scoped>
</style>
