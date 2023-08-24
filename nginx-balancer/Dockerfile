# Получение образа nginx
FROM nginx:latest

# Копируем конфигурацию хоста в docker
COPY balancer.conf /etc/nginx/conf.d/balancer.conf

# Запускаем nginx на 80 порту
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]