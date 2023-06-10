FROM nginx:latest

COPY balancer.conf /etc/nginx/conf.d/balance.conf

WORKDIR /var/www/otus

CMD ["nginx", "-g", "daemon off;"]