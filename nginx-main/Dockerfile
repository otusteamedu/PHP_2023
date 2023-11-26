FROM nginx:latest

COPY ./hosts/application.local.conf /etc/nginx/conf.d/application.local.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
