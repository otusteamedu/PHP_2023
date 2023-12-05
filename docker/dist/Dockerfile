######
# See: https://hub.docker.com/_/debian
######

FROM debian:latest
MAINTAINER Dushinov Dmitriy <example@example.com>
LABEL version="1.0"
LABEL description="sh scripting"


RUN apt-get update && apt-get install -y locales bc && rm -rf /var/lib/apt/lists/* \
	  && localedef -i ru_RU -c -f UTF-8 -A /usr/share/locale/locale.alias ru_RU.UTF-8

ENV LANG ru_RU.utf8
