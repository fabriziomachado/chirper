FROM serversideup/php:8.3-fpm-nginx-bookworm AS base
FROM base AS development

ENV PHP_OPCACHE_ENABLE=1

USER root

# ARG USER_ID
# ARG GROUP_ID
ARG USER_ID=1000
ARG GROUP_ID=1000
ENV USER_ID=${USER_ID}
ENV GROUP_ID=${GROUP_ID}

RUN install-php-extensions intl bcmath

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

RUN docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID && \
    docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID --service nginx

USER www-data

# Copia código para o build de desenvolvimento
COPY --chown=www-data:www-data . /var/www/html

# Build dos assets no stage dev
WORKDIR /var/www/html
RUN npm install
RUN npm run build

# Stage de produção: imagem enxuta, só com os arquivos necessários
FROM base AS production

USER root

# Copia apenas os arquivos finais do dev (já com build e node_modules removidos)
COPY --from=development /var/www/html /var/www/html
# COPY --chown=www-data:www-data . /var/www/html

WORKDIR /var/www/html

# Corrigir permissões
RUN mkdir -p storage/logs bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap && \
    chmod -R 775 storage bootstrap

# Troca de volta para www-data
USER www-data

# Instala dependências do Laravel para produção
RUN composer install --no-interaction --optimize-autoloader --no-dev
