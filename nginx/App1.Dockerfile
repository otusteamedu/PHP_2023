FROM nginx:latest

COPY ./conf/app1.local.conf /etc/nginx/conf.d/app1.local.conf

WORKDIR /srv/app
VOLUME /srv/app
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]