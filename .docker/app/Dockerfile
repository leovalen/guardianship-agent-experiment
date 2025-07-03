# filepath: ./Dockerfile
FROM jkaninda/laravel-php-fpm:latest

# Set the working directory
WORKDIR /var/www/html

COPY .docker/app/entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

