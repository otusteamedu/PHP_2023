FROM nginx:latest

COPY hosts/mysite1.local.conf /etc/nginx/conf.d/mysite1.local.conf

WORKDIR /data

CMD ["nginx", "-g", "daemon off;"]