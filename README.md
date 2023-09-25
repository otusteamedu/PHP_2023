# PHP_2023 
## HW 19 RabbitMQ
### Timerkhanov A.D.

1. Добавить в host файл `127.0.0.1 mysite.local`
2. Копировать файл `.env.example` в `.env`
3. Запустить контейнеры командой `docker-compose up --build -d`
4. Зайти в контейнер `docker exec -it php bash` и установить зависимости `composer i`
---

### Swagger - OpenAPI
- Находится по адресу  `http://mysite.local/api/v1/documentation/index` которое отдает нам документацию в json к которой дальше мы можем подключить web морду

### Applicatioon
`http://mysite.local/api/v1/request/post` - Создать запрос на получение данных -> возвращает  id для  отслеживания
`http://mysite.local/api/v1/request/get{request_id}` - Метод получения информации по запросу используя ID

### Для получения сообщения в очереди необходимо запустить скрипт:

6.  В контейнере `docker exec -it php bash` переходим в директорию `/script` и запускаем консульные приложения<br><br>
`php receive.php` - чтобы вывести список сообщений отправленных в очередь с запросом выписки.<br><br>
`php emailConsumer.php` - выводит список сообщений отправленных в очередь, с запросом отправики email
   с результатами выписки.<br><br>

Также состояние очередей можно посмотреть по адресу http://localhost:15672/. <br>
(login: user, password: password)