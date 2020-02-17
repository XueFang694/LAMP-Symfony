
FROM php:7.4-apache AS build


LABEL author="Geoffrey LEVENEZ"

COPY ./index.php /var/www/html/

# Lorsque le conteneur sera démarré c'est ce dossier qui sera ouvert par défaut
WORKDIR /var/www/html/

RUN apt-get update \
&& apt-get install -y \
&& rm -r /var/lib/apt/lists/*

RUN a2enmod rewrite