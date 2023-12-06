# Консальный чат на сокетах

### Использование

* Cоздаем образ для запуска инстансов чата

``` bash
docker build -t test-cli  ./docker/
```

* Запускаем чат в режиме сервера

``` bash
docker run --rm -it  -v ./:/www test-cli php /www/index.php server
```

* Отправляем сообщение:
``` bash
docker run --rm -it -v ./:/www test-cli php /www/index.php client hello!
```
