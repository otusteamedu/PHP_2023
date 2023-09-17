FROM nginx

COPY ./application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /app

VOLUME /app

EXPOSE 8871

CMD ["nginx", "-g", "daemon off;"]
