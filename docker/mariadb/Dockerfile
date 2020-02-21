FROM mariadb/server:10.4
# Evite de devoir écrire "localhost" sur un poste et "127.0.0.1" sur un autre.
RUN sed -i '/skip-name-resolve/d' /etc/mysql/conf.d/docker.cnf