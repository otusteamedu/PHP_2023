Init Docker

- cd config && cp config.ini.example.php config.ini.php
- cd ../
- docker-compose up --build -d
- docker exec -it php-server bash
- composer install
- exit;

Работа с приложением
Start Server

- docker exec -it php-server bash
- cd mysite.local
- php app.php server

Start Client

- docker exec -it php-client bash
- cd mysite.local
- php app.php client 

