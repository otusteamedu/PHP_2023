FROM nginx:1.23-alpine

COPY ./docker/nginx/config/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/config/default.conf /etc/nginx/conf.d/default.conf

ARG UID=1000
ARG GID=1000

RUN addgroup -g ${GID} -S www && adduser --uid ${UID} --ingroup www -S -g www www \
    && mkdir -p /home/www/Downloads /var/www/app \
    && rm -rf /var/www/html \
    && chown -R www:www /home/www \
    && chown -R www:www /var/www/app

WORKDIR /var/www/app

COPY --chown=www:www ./app .

EXPOSE 80

ENTRYPOINT ["nginx", "-g", "daemon off;"]
