FROM nginx:latest

COPY application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /var/www/otus

CMD ["nginx", "-g", "daemon off;"]