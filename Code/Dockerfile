FROM php:7.0.16-apache

RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev

RUN apt-get install -y \
        libxml2-dev

RUN /usr/local/bin/docker-php-ext-install mysqli pdo pdo_mysql zip xmlwriter
RUN apt-get install libssl-dev -y

RUN /usr/local/bin/docker-php-ext-install zip


# Install mcrypt
RUN apt-get install -y libmcrypt-dev
RUN docker-php-ext-install mcrypt

#RUN apt-get install php7.0.16-xml

# Install GD
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng12-dev
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd

# Install XSL
RUN apt-get install -y libxslt-dev
RUN docker-php-ext-install xsl

# Install intl
RUN apt-get install -y libicu-dev
RUN pecl install intl
RUN docker-php-ext-install intl

RUN a2enmod rewrite
RUN usermod -u 1000 www-data
RUN usermod -G staff www-data

RUN chmod -R 755 /var/www/

RUN cd /var/www/html/

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"