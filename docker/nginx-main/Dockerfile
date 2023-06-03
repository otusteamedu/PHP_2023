FROM nginx:latest

COPY nginx-main.conf /etc/nginx/conf.d/nginx-main.conf

WORKDIR /var/www/app

CMD ["nginx", "-g", "daemon off;"]