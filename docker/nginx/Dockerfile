FROM ubuntu:latest

RUN apt-get update && \
    apt-get install -y nginx

COPY ./mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

WORKDIR /srv
VOLUME /srv

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]