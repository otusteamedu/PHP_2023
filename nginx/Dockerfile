FROM nginx:latest

COPY ./hosts/application.local.conf /etc/nginx/conf.d/application.local.conf
COPY ./hosts/phpmyadmin.conf /etc/nginx/conf.d/phpmyadmin.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
