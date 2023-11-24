FROM php:8.2-cli
ARG UID
RUN apt-get update  \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        zlib1g-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd mysqli opcache \
    && usermod -u $UID www-data;
