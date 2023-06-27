FROM nginx:latest

COPY ./conf/app2.local.conf /etc/nginx/conf.d/app2.local.conf

WORKDIR /srv/app
VOLUME /srv/app
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]