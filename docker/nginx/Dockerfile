FROM nginx:1.25.2-alpine3.18

COPY hosts/myapp.local.conf /etc/nginx/conf.d/default.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
