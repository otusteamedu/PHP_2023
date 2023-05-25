FROM nginx:latest

COPY vhosts.conf /etc/nginx/conf.d/vhosts.conf

VOLUME /var/www

ENTRYPOINT ["nginx", "-g", "daemon off;"]