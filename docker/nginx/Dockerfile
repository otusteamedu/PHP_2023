FROM nginx:latest

COPY ./config/otus-homework.loc.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/otus-homework.loc

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]