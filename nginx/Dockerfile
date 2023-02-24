FROM nginx:latest

WORKDIR /socket

RUN apt-get update && apt-get install -y procps && rm -rf /var/lib/apt/lists/* \
    \
    && set -x \
    && deluser nginx \
    && groupadd --gid 1000 nginx \
    && useradd --gid 1000 nginx \
    \
    && chown -R nginx:nginx /socket

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
