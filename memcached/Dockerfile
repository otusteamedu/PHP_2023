FROM memcached:latest

COPY entrypoint.sh /usr/local/bin/

ENTRYPOINT ["entrypoint.sh"]

USER memcache

EXPOSE 11211

CMD ["memcached"]