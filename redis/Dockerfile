FROM redis:latest

COPY ./conf/redis.conf /etc/redis/redis.conf

WORKDIR /data
WORKDIR /data/bases

VOLUME /data
VOLUME /data/bases

EXPOSE 6379

CMD ["redis-server", "/etc/redis/redis.conf"]