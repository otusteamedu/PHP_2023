FROM redis
RUN apt-get update  
RUN apt-get install -y redis  
COPY ./conf/redis.conf /usr/local/etc/redis/redis.conf
WORKDIR /data
VOLUME /data
CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]