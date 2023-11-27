FROM nginx:latest

COPY ./otusphp.local.conf /etc/nginx/conf.d/otusphp.local.conf

WORKDIR /var/www/otusphp.local

VOLUME /var/www/otusphp.local

EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]
