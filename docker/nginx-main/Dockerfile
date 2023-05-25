FROM nginx:1.23-alpine

COPY ./docker/nginx-main/config/default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

ENTRYPOINT ["nginx", "-g", "daemon off;"]
