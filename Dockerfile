FROM serversideup/php:8.3-fpm-nginx-bookworm AS base
FROM base AS development

ENV PHP_OPCACHE_ENABLE=1

USER root
ARG USER_ID
ARG GROUP_ID

RUN install-php-extensions intl bcmath

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

RUN docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID && \
    docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID --service nginx

USER www-data

FROM base AS production

COPY --chown=www-data:www-data . /var/www/html


RUN npm install
RUN npm run build

RUN composer install --no-interaction --optimize-autoloader --no-dev
