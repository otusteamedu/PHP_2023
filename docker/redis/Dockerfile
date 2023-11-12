FROM redis
COPY ./config/redis.conf /usr/local/etc/redis/redis.conf
CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]
WORKDIR /data  
VOLUME /data  
EXPOSE 6379