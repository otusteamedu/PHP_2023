FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf
#COPY ./fpm/php-fpm.conf /usr/local/etc/php-fpm.conf

WORKDIR /data

VOLUME /var/run/php-fpm.sock

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

