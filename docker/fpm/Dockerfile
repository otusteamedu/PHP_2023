FROM debian:latest

## Использовал чистую ОС для освения чистой установки php и пакетов

RUN apt-get update && apt-get install curl -y
RUN apt-get install ca-certificates apt-transport-https software-properties-common curl lsb-release -y
RUN curl -sSL https://packages.sury.org/php/README.txt | bash -x
RUN apt-get update && apt-get install php8.2 php8.2-intl \
    php8.2-mbstring php8.2-curl php-json php8.2-zip php8.2-common php8.2-mysql php8.2-cgi php8.2-fpm -y

WORKDIR ./app
EXPOSE 9000

CMD ["php-fpm8.2", "-F"]