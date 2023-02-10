FROM nginx:latest

COPY application.local.conf.template /etc/nginx/templates/application.local.conf.template

WORKDIR /var/www/application.local

VOLUME /var/www/application.local

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
