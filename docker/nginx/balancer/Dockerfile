FROM nginx:1.25-alpine

COPY ./nginx/balancer/conf.d/balancer.conf /etc/nginx/conf.d/otus.local.conf

VOLUME /app

WORKDIR /app