import axios from "axios";

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
});

/**
 * Busca filmes por nome.
 * Endpoint: GET /movies/search?query={query}
 */
const searchMovies = async (query) => {
  try {
    const response = await apiClient.get("/movies/search", {
      params: { query },
    });
    return response.data;
  } catch (error) {
    console.error("Erro ao buscar filmes:", error);
    throw error;
  }
};

/**
 * Busca todos os filmes favoritos.
 * Endpoint: GET /favorites
 */
const getFavoriteMovies = async () => {
  try {
    const response = await apiClient.get("/favorites");
    return response.data;
  } catch (error) {
    console.error("Erro ao buscar filmes favoritos:", error);
    throw error;
  }
};

/**
 * Salva um filme como favorito.
 * Endpoint: POST /favorites
 * Body: { tmdb_id, title, original_title, release_date, overview, genre_ids, poster_path }
 */
const postFavoriteMovie = async (movieData) => {
  try {
    const response = await apiClient.post("/favorites", movieData);
    return response.data;
  } catch (error) {
    console.error("Erro ao salvar filme favorito:", error);
    throw error;
  }
};

/**
 * Remove um filme dos favoritos pelo ID.
 * Endpoint: DELETE /favorites/{movieId}
 */
const removeFavoriteMovie = async (movieId) => {
  try {
    const response = await apiClient.delete(`/favorites/${movieId}`);
    return response;
  } catch (error) {
    console.error(`Erro ao remover filme favorito ${movieId}:`, error);
    throw error;
  }
};

/**
 * Busca todos os gêneros de filmes.
 * Endpoint: GET /genres
 */
const getAllGenres = async () => {
  try {
    const response = await apiClient.get("/genres");
    return response.data;
  } catch (error) {
    console.error("Erro ao buscar gêneros:", error);
    throw error;
  }
};

/**
 * Busca entre os filmes favoritos por gênero.
 */
const getMoviesByGenre = async (genreId) => {
  const response = await apiClient.get(`/favorites/favoriteMoviesByGenre/${genreId}`);
  if (response.status !== 200) {
    throw new Error(`Erro ao buscar filmes por gênero ${genreId}: ${response.statusText}`);
  }
  return response;
};

/**
 * Atualiza a nota de um filme favorito.
 * Endpoint: PATCH (ou PUT) /favorites/{movieId}
 * Body: { rating }
 */
const rateFavoriteMovie = async (movieId, rating) => {
  try {
    const response = await apiClient.patch(`/favorites/${movieId}`, { rating });
    console.log(
      `Filme ${movieId} avaliado com nota ${rating}. Resposta:`,
      response.data
    );
    return response.data;
  } catch (error) {
    console.error(`Erro ao avaliar filme ${movieId}:`, error);
    throw error;
  }
};

export {
  searchMovies,
  getFavoriteMovies,
  postFavoriteMovie,
  removeFavoriteMovie,
  getAllGenres,
  getMoviesByGenre,
  rateFavoriteMovie,
}
