FROM nginx:latest

COPY hosts/mysite2.local.conf /etc/nginx/conf.d/mysite2.local.conf

WORKDIR /data

CMD ["nginx", "-g", "daemon off;"]