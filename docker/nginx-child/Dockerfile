FROM nginx

COPY ./application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /app

VOLUME /app

EXPOSE 7878

#CMD ["nginx", "-g", "daemon off;"]
