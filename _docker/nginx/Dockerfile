FROM nginx

COPY ./app.local.conf /etc/nginx/conf.d/app.local.conf

WORKDIR /data
VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
