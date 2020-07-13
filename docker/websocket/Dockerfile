FROM php:7.4.2-apache AS build


LABEL author="Geoffrey LEVENEZ"
# Parametrage de la zone geographique
RUN echo "Europe/Paris" > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata

# Lors de l'ouverture du conteneur les commandes suivantes seront executees
RUN apt-get update && \
    apt-get install -y \
    supervisor \
    && \
    rm -r /var/lib/apt/lists/* &&\
    a2enmod rewrite && \
    a2enmod expires && \
    a2enmod headers

# Place le curseur dans le dossier racine d'Apache
WORKDIR /var/www/html/
# Copie le projet dans le conteneur
RUN mkdir app/
RUN mkdir app/websocket/
COPY ./websocket ./app/websocket


# Copie le fichier de configuration de PHP
COPY ./php.ini /usr/local/etc/php/
# Copie le conteneur du conteneur Composer en global
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Copie le fichier de configuration d'apache dans le conteneur
COPY ./000-default.conf /etc/apache2/sites-enabled/000-default.conf
# Copie la configuration et initialiseur du websocket
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN mkdir /var/log/supervisord/
CMD ["/usr/bin/supervisord"]
