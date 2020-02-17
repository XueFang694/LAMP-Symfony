
FROM php:7.4.2-apache AS build


LABEL author="Geoffrey LEVENEZ"

# Lors de l'ouverture du conteneur les commandes suivantes seront exécutées
RUN apt-get update &&\
    apt-get install -y\
    git \
    zip \
    unzip \
    && \
    rm -r /var/lib/apt/lists/* &&\
    a2enmod rewrite &&\
    a2enmod expires

# Copie le projet Symfony dans le conteneur
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Copie le fichier de configuration d'apache dans le conteneur
COPY ./docker/000-default.conf /etc/apache2/sites-enabled/000-default.conf

# Installation de Symfony
WORKDIR /var/www/html/
# Récupère l'installeur dépendance de Symfony dans Composer
RUN composer require symfony/symfony
# Vérifie si Symfony a tout ce dont il a besoin
RUN symfony check:requirements