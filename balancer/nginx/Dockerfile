FROM nginx:latest

COPY app.local.conf /etc/nginx/conf.d/default.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

