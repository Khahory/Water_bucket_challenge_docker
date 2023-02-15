FROM php:7.4.33-apache

# Install dependencies
RUN apt-get update && apt-get install -y
RUN apt-get install -y gnupg && apt-get install -y curl

COPY . /var/www/html/backend

# folders permissions
RUN chown -R www-data:www-data /var/www/html/backend
RUN chmod -R 755 /var/www/html/backend

# we need to copy our Apache config file
COPY ./my-httpd.conf /usr/local/apache2/conf/httpd.conf

# restart Apache
RUN a2enmod rewrite
RUN service apache2 restart

# expose port 80
EXPOSE 80