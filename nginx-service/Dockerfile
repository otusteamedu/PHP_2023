FROM nginx:latest

COPY ./nginx-service.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data

VOLUME /data

CMD ["nginx", "-g", "daemon off;"]