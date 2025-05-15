FROM php:8.3-fpm-alpine3.20

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache make bash bash-completion

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN set -eux; \
    install-php-extensions xdebug;

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

# Добавить системного пользователя с нужным UID и GID
ARG UID=1000
ARG GID=1000

RUN addgroup -g ${GID} devgroup && \
    adduser -D -u ${UID} -G devgroup devuser

ENV TERM=xterm-256color
RUN echo "PS1='\e[92m\u\e[0m@\e[94m\h\e[0m:\e[35m\w\e[0m# '" >> /home/devuser/.bashrc

WORKDIR /app
COPY . .
#RUN composer install --no-interaction

CMD ["bash", "-c", "make start"]
#CMD ["tail", "-f", "/dev/null"]
