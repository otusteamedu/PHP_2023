FROM nginx

COPY ./conf/balancer.conf /etc/nginx/conf.d/balancer.conf

WORKDIR /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]