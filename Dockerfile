
FROM php:7.4.2-apache AS build


LABEL author="Geoffrey LEVENEZ"

# Mise à jour de l'OS
RUN apt-get update
# Lors de l'ouverture du conteneur les commandes suivantes seront exécutées

RUN apt-get install -y\
    git \
    zip \
    unzip \
    wget \
    && \
    rm -r /var/lib/apt/lists/* &&\
    a2enmod rewrite &&\
    a2enmod expires

# Copie le projet Symfony dans le conteneur
#COPY --from=composer /usr/bin/composer /usr/bin/composer
# Copie le fichier de configuration d'apache dans le conteneur
COPY ./docker/000-default.conf /etc/apache2/sites-enabled/000-default.conf

# Installation de Symfony
WORKDIR /var/www/html/
# Copie le fichier de configuration de composer
#COPY ./composer.json /var/www/html/composer.json
# Récupère l'installeur dépendance de Symfony dans Composer
RUN wget https://get.symfony.com/cli/installer -O - | bash
# Vérifie si Symfony a tout ce dont il a besoin
RUN symfony check:requirements; echo "Erreur lors de la vérification de l'installation de Symfony" exit 0
# Affiche la configuration de la machine à lors du build
RUN echo "\n\n\n\n\n\n\n\n\n\n==============CONFIGURATION==============\n\nSystème d'exploitation\n----------------------\e[32m"&&\
    cat /etc/os-release &&\
    echo "\n\n\e[39mVersion PHP\n-----------\e[32m" &&\
    php -v &&\
    echo "\n\n\e[39mContenu du projet" $(pwd) "\n------------------------------\e[32m" &&\
    ls &&\
    echo "\n\n\n\n\n\n\n\n\n\n\e[39m"