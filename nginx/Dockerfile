FROM nginx:latest

RUN apt-get update && apt-get install -y procps && rm -rf /var/lib/apt/lists/*

#RUN groupadd --gid 1000 www && \
#    useradd --gid 1000 www

#USER www

#RUN rm -rf /var/log/nginx && mkdir /var/log/nginx && chown -R www:www /var/log/nginx

#RUN touch /var/run/nginx.pid \
# && chown -R www:www \
#    /var/run/nginx.pid \
#    /var/cache/nginx \
#    /var/log/nginx

WORKDIR /data

#RUN chown -R www:www /data
#
#USER www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
