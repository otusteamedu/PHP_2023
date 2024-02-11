FROM nginx:1.25.3-alpine

RUN docker-php-ext-install sockets \
  && set -x \
  && addgroup -g 101 -S nginx \
  && adduser -u 101 -D -S -G nginx nginx

COPY ./hosts/application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]