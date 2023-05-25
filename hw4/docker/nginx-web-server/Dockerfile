FROM nginx:latest

COPY application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /var/www/html

VOLUME /var/www/html

CMD ["nginx", "-g", "daemon off;"]
