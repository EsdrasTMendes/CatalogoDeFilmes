// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import SearchMoviesView from '../components/SearchMoviesView.vue'; // Seu componente principal de busca/home
import FavoritesView from '../components/FavoritesView.vue';   // Novo componente para a página de favoritos

const routes = [
  {
    path: '/',
    name: 'SearchHome',
    component: SearchMoviesView, // Ou como você chama sua tela inicial
  },
  {
    path: '/favorites',
    name: 'Favorites',
    component: FavoritesView,
  },
  // Outras rotas que você possa ter
];

const router = createRouter({
  history: createWebHistory(), // sem BASE_URL, usa raiz "/"
  routes,
});

export default router;
