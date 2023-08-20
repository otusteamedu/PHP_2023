FROM nginx:latest

COPY .docker/nginx/hosts/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /app

EXPOSE 80 443

CMD ["nginx", "-g", "daemon off;"]
