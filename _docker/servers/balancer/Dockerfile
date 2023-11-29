FROM nginx

COPY nginx-balancer.conf /etc/nginx/conf.d/nginx-balancer.conf

WORKDIR /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
