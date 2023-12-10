FROM php:8.2-cli
RUN apt-get update  \
    && apt-get install -y --no-install-recommends \
	&& docker-php-ext-install -j$(nproc) sockets;
