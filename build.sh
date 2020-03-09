# Stop tous les conteneurs liés au projet
docker-compose down --remove-orphans && \
# Construit le conteneur
docker-compose build && \
# Démarre l'ensemble de conteneur Docker
docker-compose up -d && \
# Se place dans le dossier du projet
cd app/ && \
# S'assure que l'utilisateur possède bien toutes les dépendances de Composer requises
composer install && \
# Nettoie le cache de Symfony
php bin/console cache:clear && \
# Serveur Symfony
symfony server:start && \
# A.P.I Plateform
php -S 127.0.0.1:8000 -t public