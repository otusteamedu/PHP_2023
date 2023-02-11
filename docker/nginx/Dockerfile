FROM nginx:latest

ARG UID
RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

RUN rm /etc/nginx/nginx.conf
COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./application.local.conf /etc/nginx/conf.d/application.local.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
