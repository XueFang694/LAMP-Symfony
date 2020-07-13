FROM php:7.4.2-apache AS build


LABEL author="Geoffrey LEVENEZ"
# Parametrage de la zone geographique
RUN echo "Europe/Paris" > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata

# Lors de l'ouverture du conteneur les commandes suivantes seront executees
RUN apt-get update && \
    apt-get install -y \
    git \
    zip \
    unzip \
    nano \
    vim \
    wget \
    gnupg2 \
    && \
    docker-php-ext-configure pdo_mysql && docker-php-ext-install pdo_mysql && \
    rm -r /var/lib/apt/lists/* &&\
    a2enmod rewrite && \
    a2enmod expires && \
    a2enmod headers

# Installe BlackFire sur la machine
RUN wget -q -O - https://packages.blackfire.io/gpg.key | apt-key add -
RUN echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
RUN apt-get update && \
    apt-get install blackfire-agent blackfire-php
RUN blackfire-agent --register --server-id=bd9faad6-74b9-4ace-86b6-b03d920f29ad --server-token=db34c1968bc10417cc244a0e0bc3bbdcf653a737770473c0632e4b9f556324ab

# Copie le fichier de configuration de PHP
COPY ./docker/php_apache/php.ini /usr/local/etc/php/
# Copie le conteneur du conteneur Composer en global
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Copie le fichier de configuration d'apache dans le conteneur
COPY ./docker/php_apache/000-default.conf /etc/apache2/sites-enabled/000-default.conf

# Place le curseur dans le dossier racine d'Apache
WORKDIR /var/www/html/

# Copie le projet dans le conteneur
COPY ./app ./

WORKDIR /var/www/html/app/backend/