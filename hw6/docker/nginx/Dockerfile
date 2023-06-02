FROM nginx:latest

COPY app.local.conf /etc/nginx/conf.d/app.local.conf

VOLUME /var/www/html

VOLUME /sockets/php-fpm

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
