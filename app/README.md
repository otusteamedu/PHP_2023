# PHP_2023

разворачиваем проект docker-compose up --build -d
переходим в app/www, запускаем composer install
через postman проверяем что всё работает https://localhost:9200/_cluster/health


docker compose exec -it php bash   для выполнения команд внутри контейнера
- php index.php createIndex
- php index.php search  "title=Кто подставил поручика Ржевского на Луне" "category=Исторический роман" "minPrice=0" "maxPrice=2000"
- php index.php search "title=рыцОри" "minPrice=0" "maxPrice=2000"