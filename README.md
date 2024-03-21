
1. Скачать проект  

  ```
  git clone 
  ```
2. Зайти в папку проекта и выполнить 

```
  cd hw19/docker
  docker-compose up -d
```

3. Зайти внутрь php-fpm и запустить скрипт consumer

``` 
docker exec otus-php-fpm bash
cd ../app.loc
php index.php
```

4. Посылаем post запрос наример через postman




5. Заходим в терминал с php-fpm и видим там вывод нашего сообщения из очереди


``` ```
