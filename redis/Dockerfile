FROM redis:latest

COPY ./conf/redis.conf /etc/redis/redis.conf

WORKDIR /data

VOLUME /data

EXPOSE 6379

CMD ["redis-server", "/etc/redis/redis.conf"]