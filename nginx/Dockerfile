FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data

VOLUME /data

RUN adduser --disabled-password mysite \
    && usermod -a -G mysite nginx

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]