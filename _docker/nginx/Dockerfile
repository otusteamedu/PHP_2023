FROM ubuntu:latest
RUN apt-get update
RUN apt-get install -y nginx
RUN apt-get install nano
COPY  ./conf.d/ /etc/nginx/conf.d/
#WORKDIR /data
CMD ["nginx", "-g", "daemon off;"]