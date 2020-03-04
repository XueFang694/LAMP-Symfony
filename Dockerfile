FROM php:7.4.2-apache AS build


LABEL author="Geoffrey LEVENEZ"
# Param�trage de la zone g�ographique
RUN echo "Europe/Paris" > /etc/timezone
RUN dpkg-reconfigure -f noninteractive tzdata
# Mise � jour de l'OS
RUN apt-get update; echo "Erreur lors de la mise � jour de l'OS" exit 0
# Lors de l'ouverture du conteneur les commandes suivantes seront ex�cut�es

# Copie le fichier de configuration de PHP
COPY ./docker/php_apache/php.ini /usr/local/etc/php/

RUN apt-get install -y\
    git \
    zip \
    unzip \
    nano \
    vim \
    wget \
    && \
    docker-php-ext-configure pdo_mysql && docker-php-ext-install pdo_mysql && \
    rm -r /var/lib/apt/lists/* &&\
    a2enmod rewrite && \
    a2enmod expires && \
    a2enmod headers

# Copie le conteneur du conteneur Composer en global
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Copie le fichier de configuration d'apache dans le conteneur
COPY ./docker/php_apache/000-default.conf /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/html/

# Copie le projet Symfony dans le conteneur
COPY ./app/ ./

# Affiche la configuration de la machine � lors du build
RUN echo "\n\n\n\n\n\n\n\n\n\n==============CONFIGURATION==============\n\nSyst�me d'exploitation\n----------------------\e[32m"&&\
    cat /etc/os-release &&\
    echo "\n\n\e[39mVersion PHP\n-----------\e[32m" &&\
    php -v &&\
    echo "\n\n\e[39mContenu du projet" $(pwd) "\n------------------------------\e[32m" &&\
    ls &&\
    echo "\n\n\n\n\n\n\n\n\n\n\e[39m"