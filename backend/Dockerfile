FROM php:7.2-apache

RUN docker-php-ext-install mysqli

WORKDIR /srv

EXPOSE 80

COPY --chown=www-data:www-data *.php ./
COPY sdp2.conf /etc/apache2/sites-available/
COPY srv.* /etc/ssl/certs/

CMD [ "apache2ctl", "-D", "FOREGROUND" ]

RUN a2ensite sdp2 \
    && a2enmod rewrite \
    && a2enmod ssl \
    && a2dissite 000-default