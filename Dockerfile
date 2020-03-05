FROM php:7.4.2-apache AS build


LABEL author="Geoffrey LEVENEZ"
# Parametrage de la zone geographique
RUN echo "Europe/Paris" > /etc/timezone
RUN dpkg-reconfigure -f noninteractive tzdata
# Mise a jour de l'OS
RUN apt-get update; echo "Erreur lors de la mise a jour de l'OS" exit 0

# Lors de l'ouverture du conteneur les commandes suivantes seront executees
RUN apt-get install -y\
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
RUN wget -q -O - https://packages.blackfire.io/gpg.key | apt-key add -
RUN echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
RUN apt-get update
RUN apt-get install blackfire-agent
RUN blackfire-agent --register --server-id=bd9faad6-74b9-4ace-86b6-b03d920f29ad --server-token=db34c1968bc10417cc244a0e0bc3bbdcf653a737770473c0632e4b9f556324ab
RUN /etc/init.d/blackfire-agent restart
# Installe l'extension Blackfire pour PHP
RUN export VERSION=`php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;"` \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/${VERSION} \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    && mv /tmp/blackfire-*.so `php -r "echo ini_get('extension_dir');"`/blackfire.so \
    && echo "extension=blackfire.so\nblackfire.agent_socket=\${BLACKFIRE_PORT}" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -Rf /tmp/*




# Copie le fichier de configuration de PHP
COPY ./docker/php_apache/php.ini /usr/local/etc/php/
# Copie le conteneur du conteneur Composer en global
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Copie le fichier de configuration d'apache dans le conteneur
COPY ./docker/php_apache/000-default.conf /etc/apache2/sites-enabled/000-default.conf

# Configure Blackfire
#ENV BLACKFIRE_CONFIG /dev/null
#ENV BLACKFIRE_LOG_LEVEL 4
#ENV BLACKFIRE_SOCKET tcp://0.0.0.0:8707
#EXPOSE 8707
#COPY --from=blackfire/blackfire blackfire-agent /usr/local/bin/
#RUN addgroup -S blackfire && adduser -S -H -G blackfire -u 999 blackfire
#USER blackfire


WORKDIR /var/www/html/

# Copie le projet Symfony dans le conteneur
COPY ./app/ ./

# Affiche la configuration de la machine lors du build
RUN echo "\n\n\n\n\n\n\n\n\n\n==============CONFIGURATION==============\n\nSysteme d'exploitation\n----------------------\e[32m"&&\
    cat /etc/os-release &&\
    echo "\n\n\e[39mVersion PHP\n-----------\e[32m" &&\
    php -v &&\
    echo "\n\n\e[39mContenu du projet" $(pwd) "\n------------------------------\e[32m" &&\
    ls &&\
    echo "\n\n\n\n\n\n\n\n\n\n\e[39m"