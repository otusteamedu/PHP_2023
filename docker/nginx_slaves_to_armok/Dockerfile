FROM nginx:latest
LABEL authors="iosh"
RUN apt-get update && apt-get install -y vim

COPY conf.d/site.conf /etc/nginx/conf.d/site.conf

VOLUME /var/www

ENTRYPOINT ["nginx", "-g", "daemon off;"]