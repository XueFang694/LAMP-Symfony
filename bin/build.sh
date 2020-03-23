#!/usr/bin/env bash
ROOT=$(pwd)
# Stop tous les conteneurs lies au projet
docker-compose down --remove-orphans --volumes && \
# Construit le conteneur
docker-compose build && \
# Démarre l'ensemble de conteneur Docker
docker-compose up -d && \
# Se place dans le dossier du backend
cd app/backend && \
# S'assure que l'utilisateur possède bien toutes les dépendances de Composer requises
composer install && \
docker exec -u root -t --privileged my_app_app_symfony php bin/console doctrine:database:create --no-interaction && \
docker exec -u root -t --privileged my_app_app_symfony php bin/console doctrine:migrations:migrate --no-interaction && \
docker exec -u root -t --privileged my_app_app_symfony php bin/console doctrine:fixtures:load --no-interaction && \
# Nettoie le cache de Symfony
php bin/console cache:clear && \
# Serveur Symfony
symfony server:stop && \
symfony server:start -d --port=8000 --dir=public; echo "Le serveur est déjà démarré" && \
php -S 127.0.0.1:8000 -t public  & \
# Se place dans le dossier frontend
cd $ROOT && \
cd app/frontend && \
# S'assure que NPM est a jour
npm install -g npm && \
# Installe les dépendances
npm install && \
# Démarre le serveur et la compilation en mode développeur pour le frontend
npm run start