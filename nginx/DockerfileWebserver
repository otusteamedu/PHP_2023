FROM nginx:latest

COPY ./conf/balancer.local.conf /etc/nginx/conf.d/balancer.local.conf

WORKDIR /srv/app
VOLUME /srv/app
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]