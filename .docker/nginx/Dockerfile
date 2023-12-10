FROM nginx:latest

COPY ./config/app.conf /etc/nginx/conf.d/app.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]