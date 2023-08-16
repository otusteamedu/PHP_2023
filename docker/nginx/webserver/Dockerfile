FROM nginx:latest

COPY hosts/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /data/myapp.local

EXPOSE 80 443

CMD ["nginx", "-g", "daemon off;"]