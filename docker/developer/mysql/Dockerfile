######
# See: https://hub.docker.com/_/mysql/
######

FROM mysql:8.2
MAINTAINER Dushinov Dmitriy <example@example.com>
LABEL version="1.0"
LABEL description="Database"

######
# define timezone
######
RUN ln -sf /usr/share/zoneinfo/Europe/Moscow /etc/localtime

######
# Configurations
######
COPY ./developer/mysql/conf.d /etc/mysql/conf.d
