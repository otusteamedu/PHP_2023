FROM nginx:latest

COPY ./otus.local.conf /etc/nginx/conf.d/otus.local.conf

WORKDIR /data/otus.local

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
