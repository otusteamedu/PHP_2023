FROM nginx:latest

COPY ./nginx/mysite.conf /etc/nginx/conf.d/mysite.conf

WORKDIR /var/www/html

VOLUME /var/www/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]