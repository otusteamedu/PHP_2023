FROM nginx:latest

COPY docker/nginx/hosts/app.conf /etc/nginx/nginx.conf
COPY docker/nginx/hosts/mysite.local.conf /etc/nginx/conf.d

WORKDIR /var/www

VOLUME /var/www


EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
