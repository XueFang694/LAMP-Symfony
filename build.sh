docker-compose down --remove-orphans && \
docker-compose build --no-cache && \
docker-compose up -d && \
cd app/ && \
composer install && \
php bin/console cache:clear && \
symfony server:start