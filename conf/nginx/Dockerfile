FROM nginx:latest

COPY ./conf/nginx/hosts/otus.local.conf /etc/nginx/conf.d/otus.local.conf

WORKDIR /var/www/html

VOLUME /var/www/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]