FROM nginx:latest

COPY ./balancer.local.conf /etc/nginx/conf.d/balancer.local.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]