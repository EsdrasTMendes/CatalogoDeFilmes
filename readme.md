# 🎬 Catálogo de Filmes - Full Stack Challenge

Aplicação full stack para buscar, favoritar e listar filmes utilizando a API pública do [The Movie Database (TMDB)](https://developer.themoviedb.org/reference/intro/getting-started).

---

## 🚀 Tecnologias Utilizadas

- **Back-end:** Laravel (PHP 8.2)
- **Front-end:** Vue.js (SPA)
- **Banco de dados:** MySQL
- **Ambiente:** Docker + docker-compose
- **Versionamento:** Git + GitHub

---

## ⚙️ Como rodar o projeto com Docker

### 1. Clone o repositório

```bash
git clone https://github.com/SeuUsuario/seu-repo.git
cd seu-repo
```

### 2 . Copie o arquivo de ambiente
 ```bash
  cp src/.env.example src/.env
 ```

  Atualize a variável DB_HOST para db no arquivo .env

  ### 3 . Suba os containers
 ```bash
  docker-compose up -d
 ```

  ### 4 . Acesse o container do app
 ```bash
  docker exec -it catalogo_app bash
 ```

  ### 5 . Instale as dependências e gere a key
 ```bash
  composer install 
  php artisan key:generate
  php artisan migrate
 ```

  ### 6. Acesse a aplicação

  Abra o seu navegador e vá para: http://localhost:8000


### 🧪 Em desenvolvimento
 - Integração com TMDB

 - Favoritar filmes

 - Listar por gênero

 - Filtrar favoritos

 - Remover favoritos

 - Testes automatizados

