FROM nginx:latest

COPY hosts/nginx.conf /etc/nginx/nginx.conf

WORKDIR /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
