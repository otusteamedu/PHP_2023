
1. Скачать проект  

  ```
  git clone git@github.com:otusteamedu/PHP_2023.git
  ```
2. Зайти в папку проекта и выполнить 

```
  git checkout GKarman/hw-19-rabbitMQ
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
- на хост http://app.loc/
- формат json поля 
    - email_to  
    - create_date_from
    - create_date_to

пример запроса
``` 
curl --location 'http://app.loc/' \
--form 'email_to="test@mail.ru"' \
--form 'create_date_from="2024-01-01"' \
--form 'create_date_to="2024-01-30"' 
```

5. Заходим в терминал с php-fpm и видим там вывод нашего сообщения из очереди

```
 [x] Received O:69:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequest":4:{s:77:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequestuserId";O:58:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Id":1:{s:62:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Idid";i:1;}s:79:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequestdateFrom";O:70:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateFrom":1:{s:80:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateFromdateFrom";O:8:"DateTime":3:{s:4:"date";s:26:"2024-01-01 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}}s:77:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequestdateTo";O:68:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateTo":1:{s:76:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateTodateTo";O:8:"DateTime":3:{s:4:"date";s:26:"2024-01-30 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}}s:78:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequestemailTo";O:61:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Email":1:{s:68:"Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Emailemail";s:12:"test@mail.ru";}}
```
