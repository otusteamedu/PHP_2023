# Получение образа nginx
FROM nginx:latest

# Копируем конфигурацию хоста в docker
COPY ./hosts/website.local.conf /etc/nginx/conf.d/website.local.conf

# Рабочая директорию www
WORKDIR /www

# Монтируем папку /www
VOLUME /www

# Запускаем nginx на 80 порту
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]