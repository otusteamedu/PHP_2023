FROM nginx:1.23-alpine

RUN adduser -u 984 -S -G www-data www-data

COPY ./docker/nginx/config/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/config/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/app

COPY ./src .

EXPOSE 80

ENTRYPOINT ["nginx", "-g", "daemon off;"]
