FROM nginx

COPY ./app.local.conf /etc/nginx/conf.d/app.local.conf

WORKDIR /var/www
VOLUME /var/www

EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]
