FROM nginx:latest
LABEL authors="iosh"

COPY ./conf.d/balance.conf /etc/nginx/conf.d/balance.conf
EXPOSE 80

ENTRYPOINT ["nginx", "-g", "daemon off;"]