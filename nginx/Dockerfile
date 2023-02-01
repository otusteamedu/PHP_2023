FROM nginx:latest

RUN apt-get update && apt-get install -y procps && rm -rf /var/lib/apt/lists/*

RUN set -x \
        && deluser nginx \
        && groupadd --gid 1000 nginx \
        && useradd --gid 1000 nginx

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
