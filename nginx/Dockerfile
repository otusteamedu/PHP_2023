FROM nginx:latest

COPY ./mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data

VOLUME /data

VOLUME /var/run/php-fpm.sock

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]