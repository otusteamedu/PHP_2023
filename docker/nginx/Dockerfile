FROM nginx

COPY ./application.local.conf /etc/nginx/conf.d/application.local.conf

COPY ./index.html /data/application.local/index.html

WORKDIR /app

VOLUME /app

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
