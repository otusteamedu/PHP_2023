
# Задание

1. Верификация строки со скобками 

    ```
    Используя Docker, вы описали сборку двух контейнеров – один с nginx, второй – с php-fpm и вашим кодом.
    Используя docker-compose вы запускаете оба контейнера.
    Контейнер с nginx пробрасывает 80 порт на вашу хостовую машину и ожидает соединений.
    Клиент соединяется, и шлёт следующий HTTP-запрос:
    POST / HTTP/1.1
    string=(()()()())(((((()()()))(()()()(((()))))))(()
   ```
2. String - это POST-параметр, который можно проверять:
3. На непустоту
```
На корректность кол-ва открытых и закрытых скобок
Все запросы с динамическим содержимым (*.php) nginx, используя директиву fastcgi_pass, проксирует в контейнер с php-fpm и вашим кодом.
Nginx должен обрабатывать запросы не обращая внимания на директиву Host. После обработки,
• если строка корректна, то пользователю возвращается ответ 200 OK, с информационным текстом, что всё хорошо;
• если строка некорректна, то пользователю возвращается ответ 400 Bad Request, с информационным текстом, что всё плохо.
```
4. Создать балансируемый кластер
5. Балансировщик nginx-upstream
6. Балансируемые бэкенды на nginx (у каждого свой php-fpm, в идеале - можно запрашивать любой доступный fpm)
7. Подключите к обоим контейнерам fpm контейнер с Memcache
8. Если у Вас есть балансировка, стандартными сессиями уже не обойтись. Иначе не будет работать аутентификация. Переведите хранение сессий в него

9. Усложнённая задача для тех, кто хочет проверить свои силы

    Объедините оба Memcache в кластер. Можно использовать Repcached

# Установка

Далее, заполните все пустые строки нужными данными в файле `.env` по аналогии с файлом `.env.example`

После чего выполните команду для запуска среды

```bash
sudo docker compose up
```

Перейдите в контейнер php и запустите composer
```bash
sudo docker container exec -it myapp-memcached-dev bash
```
```bash
cd /data/www && composer install
```

Добавьте сайт `app.local` в файл `hosts`

```bash
127.0.0.1 app.local
```

Перейдя по ссылке `http://app.local` вы увидите страницу с информацией о том, на каком Вы сервере, состояние сессии и информацию о подключённых системах.

Перейдя по ссылке `http://app.local/post.php` POST запросом с параметром `string` в body, Вы увидите сообщение:

```text
"Your string '<string>' is valid"
```
