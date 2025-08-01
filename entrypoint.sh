!/bin/sh
set -e

if [ ! -f vendor/autoload.php ]; then
  composer install --no-interaction
fi

if ! grep -q 'APP_KEY=base64' .env; then
    make setup
fi

exec "$@"

