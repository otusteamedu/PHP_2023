FROM nginx
COPY ./conf.d/testapp.conf /etc/nginx/conf.d/testapp.conf
WORKDIR /data
VOLUME /data
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]