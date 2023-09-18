FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data  

#Примонтированые данные из хостовой ОС - двунаправленная директория
VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]