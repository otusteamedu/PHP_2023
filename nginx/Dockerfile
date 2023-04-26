FROM nginx:lastest

COPY ./hosts/application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "deamon off;"]