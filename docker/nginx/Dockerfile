FROM nginx:alpine

RUN addgroup -g 1001 -S web
RUN adduser -u 1001 -S -G web web

RUN rm /etc/nginx/nginx.conf
COPY nginx.conf /etc/nginx/nginx.conf
COPY conf.d/application.local.conf /etc/nginx/conf.d/application.local.conf

CMD ["nginx", "-g", "daemon off;"]