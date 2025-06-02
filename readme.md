# 🎬 Catálogo de Filmes - Full Stack Challenge King Host

Aplicação full stack para buscar, favoritar, avaliar e listar filmes utilizando a API pública do [The Movie Database (TMDB)](https://developer.themoviedb.org/reference/intro/getting-started) e um backend próprio para gerenciar os favoritos e suas avaliações.

---

## ✨ Funcionalidades Implementadas

* Busca de filmes em tempo real utilizando a API do TMDB.
* Visualização de detalhes dos filmes (título, poster, sinopse, data de lançamento).
* Adicionar e remover filmes aos favoritos (persistidos no banco de dados).
* Listar todos os filmes favoritos.
* Avaliar filmes que estão na lista de favoritos.
* Filtrar filmes favoritos por gênero.
* Navegação baseada em rotas para a tela de busca e tela de favoritos.
* Interface responsiva e amigável.

---

## 🚀 Tecnologias Utilizadas

* **Back-end:** Laravel (PHP 8.2)
* **Front-end:** Vue.js 3 (Composition API, Vite)
* **Banco de dados:** MySQL 8.0
* **Servidor Web Frontend:** Nginx (dentro do Docker)
* **Ambiente de Desenvolvimento e Entrega:** Docker & Docker Compose
* **Estilização:** Tailwind CSS
* **Cliente HTTP:** Axios
* **Versionamento:** Git + GitHub

---

## 📋 Pré-requisitos

Antes de começar, garanta que você tem as seguintes ferramentas instaladas e funcionando corretamente na sua máquina:

* [Docker](https://www.docker.com/get-started)
* [Docker Compose](https://docs.docker.com/compose/install/) (geralmente já vem com o Docker Desktop)
* [Git](https://git-scm.com/downloads)

---

## ⚙️ Configuração do Ambiente

Siga os passos abaixo para configurar o ambiente localmente:

### 1. Clone o Repositório

Primeiro, clone este repositório para a sua máquina local:
```bash
git clone https://github.com/EsdrasTMendes/CatalogoDeFilmes.git
```
entre em seu repositório
```bash
cd seu-repositorio-destino
```
abra o projeto no seu editor de código de sua preferência.



### 2. Configure as Variáveis de Ambiente

O projeto utiliza um arquivo `.env` na raiz para configurar o Docker Compose e as variáveis de ambiente para os containers.

1.  **Copie o arquivo de exemplo:**
    Na raiz do projeto clonado, você encontrará um arquivo chamado `.env.example`. Copie este arquivo para um novo arquivo chamado `.env` no mesmo local:

    ```bash
    # No Windows (usando PowerShell):
    Copy-Item .env.example .env

    # No Linux ou macOS:
    cp .env.example .env
    ```

2.  **Edite o arquivo `.env`:**
    Abra o arquivo `.env` que você acabou de criar com um editor de texto.

    * **OBRIGATÓRIO:**
        * `TMDB_API_KEY`: Você **precisa** substituir o valor de exemplo por sua própria chave de API (v4 auth token) do The Movie Database. Você pode obter uma gratuitamente registrando-se no [site do TMDB](https://www.themoviedb.org/signup) e seguindo as instruções para gerar uma chave de API em [Settings > API](https://www.themoviedb.org/settings/api).
            ```env
            TMDB_API_KEY="SUA_CHAVE_REAL_DA_API_TMDB_V4_AUTH_TOKEN_AQUI"
            ```
            Sem uma chave válida, a sincronização de gêneros e a busca de filmes não funcionarão.

    * **OPCIONAL (Alterar apenas se houver conflitos de porta na sua máquina):**
        * `APP_PORT=8000`: Porta em que o backend Laravel (API) será acessível no seu computador. Se a porta 8000 já estiver em uso, você pode mudar para outra (ex: `8001`).
        * `FRONTEND_PORT=80`: Porta em que o frontend Vue.js (servido pelo Nginx) será acessível no seu navegador. Se a porta 80 estiver em uso, você pode mudar para outra (ex: `8080`).
        * `DB_EXPOSED_PORT=3307`: Porta para acessar o banco de dados MySQL diretamente da sua máquina host (usando um cliente de DB, por exemplo). Se a porta 3307 estiver em uso, você pode mudar.

    As demais variáveis (`APP_KEY`, `MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD`, `MYSQL_ROOT_PASSWORD`, `LARAVEL_DB_...`) geralmente podem ser mantidas com os valores padrão do `.env.example` para este ambiente de desenvolvimento/teste. A `APP_KEY` fornecida é um exemplo; para um ambiente de produção, uma nova chave segura seria gerada.

    Seu arquivo `.env` (após a edição da `TMDB_API_KEY`) deve se parecer com:
    ```env
    APP_NAME=CatalogoDeFilmes
    APP_ENV=local
    APP_KEY="base64:15GrF3NR8DdM88lTPHX05D6inAEch7Zx9hSBMwLo2QE=" # Chave de exemplo
    APP_DEBUG=true
    APP_URL=http://localhost:8000
    APP_PORT=8000

    FRONTEND_PORT=80

    TMDB_API_KEY="SUA_CHAVE_REAL_DA_API_TMDB_V4_AUTH_TOKEN_AQUI" # <-- IMPORTANTE!

    MYSQL_DATABASE=catalogo_filmes
    MYSQL_USER=user
    MYSQL_PASSWORD=userpassword
    MYSQL_ROOT_PASSWORD=rootpassword
    DB_EXPOSED_PORT=3307

    LARAVEL_DB_CONNECTION=mysql
    LARAVEL_DB_HOST=db
    LARAVEL_DB_PORT=3306
    LARAVEL_DB_DATABASE=${MYSQL_DATABASE}
    LARAVEL_DB_USERNAME=${MYSQL_USER}
    LARAVEL_DB_PASSWORD=${MYSQL_PASSWORD}

    LARAVEL_SESSION_DRIVER=database
    LARAVEL_QUEUE_CONNECTION=database
    LARAVEL_CACHE_STORE=database
    LARAVEL_LOG_CHANNEL=stderr
    ```

---

## ▶️ Como Rodar a Aplicação com Docker

Após clonar o repositório e configurar o arquivo `.env` na raiz do projeto:

1.  **Construa as imagens Docker e inicie os containers:**
    Navegue até a pasta raiz do projeto no seu terminal e execute o seguinte comando:
    ```bash
    docker-compose up -d --build
    ```
    * `--build`: Constrói (ou reconstrói) as imagens Docker para os serviços definidos no `docker-compose.yml` (backend e frontend).
    * `-d`: Roda os containers em modo "detached" (em segundo plano).

    Este comando fará automaticamente:
    * Build da imagem do backend Laravel.
    * Build da imagem do frontend Vue.js (incluindo o build do Vue e configuração do Nginx).
    * Download da imagem do MySQL.
    * Criação e inicialização dos três containers (app, frontend, db).
    * O container do backend (`app`), ao iniciar, executará um script (`entrypoint.sh`) que:
        * Aguarda o banco de dados estar pronto.
        * Cria um arquivo `.env` dentro do container se necessário (baseado no `.env.example` da `src/`).
        * Verifica/configura a `APP_KEY` do Laravel.
        * Limpa e gera o cache de configuração do Laravel (usando as variáveis de ambiente injetadas).
        * Executa as `migrations` do banco de dados para criar as tabelas necessárias.
        * Executa o comando `php artisan db:genres` para popular a tabela de gêneros com dados da API TMDB (requer `TMDB_API_KEY` válida).
        * Inicia o servidor de desenvolvimento do Laravel (`php artisan serve`).

2.  **Acesse a Aplicação:**
    Aguarde alguns instantes para que os containers iniciem completamente (o build inicial pode demorar um pouco).

    * **Frontend (Aplicação Vue.js):** Abra seu navegador e acesse:
        `http://localhost`
        (Se você alterou `FRONTEND_PORT` no arquivo `.env`, use `http://localhost:SUA_PORTA_FRONTEND`).

    * **Backend (API Laravel):** A API estará rodando e acessível em:
        `http://localhost:8000/api/`
        (Se você alterou `APP_PORT` no arquivo `.env`, use `http://localhost:SUA_PORTA_BACKEND/api/`). O frontend já está configurado para se comunicar com esta URL base.

---

## 📂 Estrutura do Projeto (Principais Pastas)

```
.
├── FrontEnd/               # Código-fonte do Vue.js (SPA)
│   ├── Dockerfile          # Dockerfile para o build e Nginx do frontend
│   └── .env                # Exemplo: VITE_API_BASE_URL (usado no build Docker e dev local)
├── src/                    # Código-fonte do Laravel (Back-end)
│   ├── app/                # Lógica principal do Laravel
│   ├── config/             # Arquivos de configuração do Laravel
│   ├── database/
│   │   ├── migrations/     # Migrations do banco de dados
│   │   └── ...
│   ├── public/             # Ponto de entrada público do Laravel (não usado diretamente aqui)
│   ├── routes/
│   │   ├── api.php         # Definição das rotas da API
│   │   └── web.php
│   ├── .env.example        # Arquivo de exemplo para o Laravel (para dev sem Docker)
│   └── ...
├── .github/                # (Opcional) Workflows do GitHub Actions
│   └── workflows/
├── .env                    # ARQUIVO PRINCIPAL de configuração para Docker Compose (VOCÊ CRIA)
├── .env.example            # Arquivo de exemplo para o .env da raiz do projeto
├── .gitignore
├── Dockerfile              # Dockerfile para o Back-end Laravel
├── docker-compose.yml      # Arquivo de orquestração do Docker Compose
├── entrypoint.sh           # Script de inicialização para o container do Back-end Laravel
├── nginx.conf              # Configuração do Nginx para servir o Front-end
└── README.md               # Este arquivo de documentação
```

---

## 🛠️ Comandos Úteis do Docker Compose

(Execute-os na raiz do projeto, onde está o `docker-compose.yml`)

* **Verificar logs dos containers (essencial para debugging):**
    ```bash
    docker-compose logs -f           # Logs de todos os serviços em tempo real
    docker-compose logs -f app       # Logs apenas do backend Laravel
    docker-compose logs -f frontend  # Logs apenas do frontend Nginx
    docker-compose logs -f db        # Logs apenas do MySQL
    ```

* **Parar e remover os containers, redes e volumes anônimos:**
    ```bash
    docker-compose down
    ```

* **Parar e remover containers E VOLUMES NOMEADOS (CUIDADO: apaga os dados do banco de dados `db_data`):**
    ```bash
    docker-compose down -v
    ```

* **Listar containers em execução e seus status:**
    ```bash
    docker-compose ps
    ```

* **Acessar o terminal de um container em execução (ex: para rodar comandos `artisan` no backend):**
    ```bash
    docker-compose exec app bash
    ```
    Uma vez dentro do container `app`, você pode rodar comandos como `php artisan list`, `php artisan tinker`, etc.

---

## 🔧 Troubleshooting / Dicas Rápidas

* **Erro "Port is already allocated" ou "address already in use":**
    Significa que a porta definida em `APP_PORT`, `FRONTEND_PORT` ou `DB_EXPOSED_PORT` no seu arquivo `.env` da raiz já está sendo usada por outro serviço na sua máquina. Altere para uma porta diferente e tente `docker-compose up -d --build` novamente.

* **Falha na sincronização de gêneros (`php artisan db:genres`):**
    Verifique os logs do container `app` (`docker-compose logs -f app`). A causa mais comum é uma `TMDB_API_KEY` inválida ou ausente no seu arquivo `.env` da raiz. O servidor backend ainda tentará iniciar, mas a funcionalidade de gêneros pode estar comprometida.

* **Erro `APP_KEY` ou `TMDB_API_KEY` "Failed to parse dotenv file":**
    Certifique-se que no seu arquivo `.env` da raiz, os valores de `APP_KEY` e `TMDB_API_KEY` (e outras variáveis longas ou com caracteres especiais) estão entre aspas duplas. Ex: `APP_KEY="base64:..."`.

* **Frontend não conecta ao Backend (Erro de Rede, CORS):**
    * Verifique se o backend (`catalogo_app`) está rodando sem erros (`docker-compose logs -f app`).
    * Confirme se a variável `VITE_API_BASE_URL` no `args` do serviço `frontend` no `docker-compose.yml` está correta (ex: `http://localhost:8000` se `APP_PORT=8000`).
    * O Laravel já vem com uma configuração básica de CORS em `config/cors.php`. Para este ambiente Docker, `localhost` (com a porta do frontend) deve geralmente funcionar. Se houver problemas de CORS, pode ser necessário ajustar `Allowed Origins` lá.

* **Permissões de Pasta (Linux/macOS):**
    Se o Laravel reclamar de permissões de escrita nas pastas `storage` ou `bootstrap/cache` (você verá nos logs do `app`), pode ser um problema de UID/GID entre seu usuário host e o usuário `www-data` dentro do container. O `Dockerfile` tenta definir permissões, mas em alguns casos pode ser necessário um `chmod -R 777 src/storage src/bootstrap/cache` no host (use com cautela).

---

## 🔮 Como o código evoluiria se houvesse tempo: 

* Implementaria testes automatizados (PHPUnit para o backend, Vitest/Jest para o frontend).
* Adicionaria paginação para listas longas de filmes (favoritos e resultados de busca).
* Melhoraria a interface do usuário e experiência (UX) com animações, feedback visual mais rico.
* Implementaria autenticação de usuários para que cada um tenha sua própria lista de favoritos.
* Utilizaria um servidor web mais robusto para o Laravel em "produção" (Nginx + PHP-FPM) em vez do `php artisan serve`. (Para este desafio, `artisan serve` é aceitável).

---

## 👤 Autor

**Esdras Tenório Mendes**

* [LinkedIn](https://www.linkedin.com/in/esdrast/)
* [GitHub](https://github.com/EsdrasTMendes)

*Agradeço pela oportunidade de resolver o desafio técnico, ele me trouxe algumas dores de cabeça, mas me diverti na maioria do tempo.
As cores escolhidas e layout do CSS foram inspiradas pelas cores da KingHost, espero ter feito um bom trabalho rs*