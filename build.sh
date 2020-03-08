docker-compose down --remove-orphans && \
docker-compose build && \
docker-compose up -d && \
cd app/ && \
composer install && \
php bin/console cache:clear && \
symfony server:start