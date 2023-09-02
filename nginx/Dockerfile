FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

RUN addgroup --gid 3000 --system safeapp
RUN adduser --uid 3000 --system --disabled-login --disabled-password --gid 3000 safeuser

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]