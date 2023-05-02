FROM nginx:latest

COPY ./hosts/app.local.conf /etc/nginx/conf.d/app.local.conf

WORKDIR /data

VOLUME /var/run/d-socket

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]