FROM nginx:latest

COPY ./conf/app.local.conf /etc/nginx/conf.d/app.local.conf

WORKDIR /srv/app

VOLUME /srv/app

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]