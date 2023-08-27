FROM nginx:latest

COPY hosts/mysite.string.conf /etc/nginx/conf.d/mysite.string.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
