# Devlog

Devlog - это REST API для ведения блога, построенный на фреймворке Laravel. Система позволяет авторам создавать и управлять постами, а авторизированным пользователям - оставлять комментарии к постам.

## Требования

- Docker
- Docker Compose

## Установка
```bash
./setup.sh
docker-compose up --build
```
После сборки контейнеров:
```bash
docker compose exec app make setup
```

## Использование

После установки API будет доступно по адресу `http://localhost:8000/api/v1/`.

## Тестирование

Для запуска тестов используйте:
```bash
docker-compose exec app php artisan test
```