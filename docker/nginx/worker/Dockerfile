FROM nginx:1.25-alpine

COPY ./nginx/worker/conf.d/worker.conf /etc/nginx/conf.d/otus.local.conf

VOLUME /app

WORKDIR /app