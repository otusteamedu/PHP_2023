FROM nginx:latest

COPY ./vhosts.conf /etc/nginx/conf.d/vhosts.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]