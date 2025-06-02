import { createRouter, createWebHistory } from 'vue-router';
import SearchMoviesView from '../components/SearchMoviesView.vue';
import FavoritesView from '../components/FavoritesView.vue';

const routes = [
  {
    path: '/',
    name: 'SearchHome',
    component: SearchMoviesView,
  },
  {
    path: '/favorites',
    name: 'Favorites',
    component: FavoritesView,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
