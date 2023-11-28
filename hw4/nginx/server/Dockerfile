FROM nginx:latest

COPY ./otusphp.local.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/otusphp.local

VOLUME /var/www/otusphp.local

CMD ["nginx", "-g", "daemon off;"]
