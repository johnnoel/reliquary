FROM php:8.0-fpm
RUN apt update && apt install -y libicu-dev
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install intl
RUN echo "date.timezone = Europe/London" >> /usr/local/etc/php/conf.d/timezone.ini
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/errors.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/errors.ini
RUN echo "upload_max_filesize = 64M" >> /usr/local/etc/php/conf.d/upload.ini
RUN echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/post.ini
