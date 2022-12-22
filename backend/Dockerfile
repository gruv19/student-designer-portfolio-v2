FROM php:7.2-apache

RUN docker-php-ext-install mysqli
# RUN docker-php-ext-install pdo_mysql

WORKDIR /srv

EXPOSE 8080

COPY *.php ./
COPY sdp2.conf /etc/apache2/sites-available/

CMD [ "apache2ctl", "-D", "FOREGROUND" ]

RUN a2ensite sdp2 \
    && a2enmod rewrite \
    && a2dissite 000-default