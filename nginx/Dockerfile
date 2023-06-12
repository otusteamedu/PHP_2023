FROM nginx:latest

COPY hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf
COPY ./hosts/upstreams.conf /etc/nginx/conf.d/upstreams.conf

WORKDIR /var/www

VOLUME /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]