FROM nginx:latest  

COPY ./hosts/application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /data/application.local

VOLUME /data/application.local

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]