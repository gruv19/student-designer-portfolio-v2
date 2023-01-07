FROM php:7.2-apache

RUN docker-php-ext-install mysqli

WORKDIR /srv

EXPOSE 8082

COPY --chown=www-data:www-data *.php ./
COPY sdp2.conf /etc/apache2/sites-available/

RUN sed -i "s/Listen 80/Listen 8082/" /etc/apache2/ports.conf
RUN mkdir work_images && chown www-data:www-data work_images

CMD [ "apache2ctl", "-D", "FOREGROUND" ]

RUN a2ensite sdp2 \
    && a2enmod rewrite \
    && a2dissite 000-default