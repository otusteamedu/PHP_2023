# PHP_2023

разворачиваем проект docker-compose up --build -d
переходим в app/www, запускаем composer install

docker compose exec -it php bash   для выполнения команд внутри контейнера

- Очистить эластик : php index.php cleanup
- Загружаем индексы и данные : php index.php createIndex
https://localhost:9200/otus-shop/_search  проверяем данные
- Посмотреть все данные :  php index.php allData
- Поиск по названию, категории и цене : php index.php search  "title=Кто подставил поручика Ржевского на Луне" "category=Исторический роман" "minPrice=0" "maxPrice=2000"