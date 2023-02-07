FROM nginx:latest

COPY application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /var/www/application.local

VOLUME /var/www/application.local
VOLUME /var/run/d-socket

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
