FROM nginx:latest

ARG UID

COPY hosts/myapp.local.conf /etc/nginx/conf.d/myapp.local.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

RUN addgroup --gid $UID --system app \
 && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

CMD ["nginx", "-g", "daemon off;"]