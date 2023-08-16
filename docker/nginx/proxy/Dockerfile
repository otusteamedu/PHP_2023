FROM nginx:latest

COPY hosts/myapp.local.conf /etc/nginx/conf.d/myapp.local.conf

EXPOSE 80 443

CMD ["nginx", "-g", "daemon off;"]