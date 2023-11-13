FROM nginx:latest

RUN mkdir -p /var/www/otusphp.local
COPY ./otusphp.local.conf /etc/nginx/conf.d/otusphp.local.conf

WORKDIR /app

VOLUME /app

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
