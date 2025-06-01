import axios from "axios";

const API_KEY = "sua_chave_aqui"; // Substitua se for necessário
const API_URL = "http://127.0.0.1:8000/api/movies/search";

const apiClient = axios.create({
  baseURL: API_URL,
  params: {
    api_key: API_KEY,
  },
});

export const searchMovies = async (query) => {
  try {
    const response = await apiClient.get("", {
      params: { query },
    });
    return response.data;
  } catch (error) {
    console.error("Erro ao buscar filmes:", error);
    throw error;
  }
};

export const getFavoriteMovies = async () => {}

export const postFavoriteMovies = async () => {}

export const removeFavoriteMovies = async () => {}

export const getAllGenresMovies = async () => {}

export const getMoviesByGenre = async (genreId) => { console.log (`Buscando filmes do gênero ${genreId}`);}

export const ratingFavoriteMovies = async (movieId, rating) => {
  console.log(`Avaliando filme ${movieId} com nota ${rating}`);
}
