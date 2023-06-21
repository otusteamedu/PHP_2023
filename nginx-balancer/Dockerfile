FROM nginx:latest

COPY balance.conf /etc/nginx/conf.d/balance.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]