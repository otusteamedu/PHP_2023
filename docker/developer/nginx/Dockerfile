######
# See: https://hub.docker.com/_/nginx/
######

FROM nginx:1.25-alpine
MAINTAINER Dushinov Dmitriy <example@example.com>
LABEL version="1.0"
LABEL description="Nginx webserver"

######
# define timezone
######
RUN ln -sf /usr/share/zoneinfo/Europe/Moscow /etc/localtime

######
# Configurations
######
COPY ./developer/nginx/conf.d /etc/nginx/conf.d

######
# workdir
######
WORKDIR /app
