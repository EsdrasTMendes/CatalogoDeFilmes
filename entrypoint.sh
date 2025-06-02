#!/bin/sh
set -e

echo "Backend Entrypoint: Iniciando..."
echo "Backend Entrypoint: Aguardando o banco de dados (delay de 20s)..."
sleep 20

if [ ! -f /var/www/.env ] && [ -f /var/www/.env.example ]; then
  echo "Backend Entrypoint: /var/www/.env não encontrado. Copiando de .env.example..."
  cp /var/www/.env.example /var/www/.env
elif [ ! -f /var/www/.env ]; then
  echo "Backend Entrypoint: ATENÇÃO - /var/www/.env E /var/www/.env.example não encontrados!"
  echo "Backend Entrypoint: Criando um .env vazio para key:generate..."
  touch /var/www/.env
fi

echo "Backend Entrypoint: Verificando APP_KEY..."
if [ -n "$APP_KEY" ]; then
    if ! grep -q "^APP_KEY=$APP_KEY" /var/www/.env; then
        echo "Backend Entrypoint: Atualizando/Adicionando APP_KEY no arquivo /var/www/.env com valor do ambiente..."
        sed -i '/^APP_KEY=/d' /var/www/.env
        echo "APP_KEY=\"$APP_KEY\"" >> /var/www/.env
    fi
    echo "Backend Entrypoint: APP_KEY está definida no ambiente."
else
    echo "Backend Entrypoint: APP_KEY NÃO está definida no ambiente. Tentando gerar..."
    php artisan key:generate
fi

echo "Backend Entrypoint: Rodando 'php artisan config:clear'..."
php artisan config:clear

echo "Backend Entrypoint: Rodando 'php artisan config:cache'..."
php artisan config:cache

echo "Backend Entrypoint: Rodando migrations..."
php artisan migrate --force --no-interaction

echo "Backend Entrypoint: Tentando rodar 'php artisan db:genres'..."
php artisan db:genres --no-interaction || echo "AVISO: Comando db:genres falhou. Verifique TMDB_API_KEY. O servidor continuará."

echo "Backend Entrypoint: Setup concluído. Executando comando principal: $@"
exec "$@"