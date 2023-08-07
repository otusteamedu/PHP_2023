FROM nginx

COPY nginx.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]