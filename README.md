# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

Для работы проекта требуется .env файл

Запрос делается следующей командой

```
docker-compose exec php php public/index.php -t "Кто подставил поручика Ржевского на Луне" -c "Сад и огород" -p 1000
```

json и сертификат для заполнения начальными данными лежат в корне директории docker

Для заполнения данными перейти в docker и выполнить команду

```
curl \                                                                                                   
      --location \
      --insecure \
      --request POST 'https://localhost:9200/_bulk' \
      --cacert http_ca.crt \
      --header 'Content-Type: application/json' \
      --data-binary "@books.json" \
      -u 'elastic:secret'
```

Если при запуске контейнеров es01 завершается с ошибкой 78, то для mac os можно выполнить следующие команды
```
docker run -it --rm --privileged --pid=host justincormack/nsenter1
sysctl -w vm.max_map_count=262144
exit
```

Если будет выдаваться ошибка авторизации то можно просто сменить пароль

```
docker exec -it es01 /usr/share/elasticsearch/bin/elasticsearch-reset-password -u elastic 
```
