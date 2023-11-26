FROM debian:latest

## Использовал чистую ОС для освения чистой установки php и пакетов

RUN apt-get update && apt-get install curl -y
RUN apt-get install ca-certificates apt-transport-https software-properties-common curl lsb-release -y
RUN curl -sSL https://packages.sury.org/php/README.txt | bash -x
RUN apt-get update && apt-get install php8.3 php8.3-intl \
    php-mbstring php-curl php-json php-zip php-common php-mysql php-fpm -y

WORKDIR ./app
EXPOSE 9000

#CMD ["php-fpm"]
CMD ["sleep", "infinity"]