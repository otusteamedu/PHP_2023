FROM nginx:latest

COPY otusphp.local.conf /etc/nginx/conf.d/otusphp.local.conf

WORKDIR /var/www/otusphp.local

CMD ["nginx", "-g", "daemon off;"]
