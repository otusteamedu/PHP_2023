FROM nginx:latest

COPY ./conf/nginx/main.conf /etc/nginx/conf.d/main.conf

WORKDIR /var/www/html

VOLUME /var/www/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]