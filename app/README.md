# PHP_2023

разворачиваем проект docker-compose up --build -d
docker compose exec -it php bash
cd /var/www
запускаем composer install

docker compose exec -it php bash   для выполнения команд внутри контейнера

- Очистить эластик : php index.php "command=cleanup"
- Загружаем индексы и данные : php index.php "command=createIndex"
https://localhost:9200/otus-shop/_search  проверяем данные
- Посмотреть все данные :  php index.php "command=allData"
- Поиск по названию, категории и цене : php index.php "command=search" "title=Кто подставил поручика Ржевского на Луне" "category=Исторический роман" "minPrice=0" "maxPrice=2000"