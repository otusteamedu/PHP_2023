FROM nginx

EXPOSE 80

COPY application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /data

CMD ["nginx", "-g", "daemon off;"]