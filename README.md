# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus


## Usage

After starting the application, execute the following cURL request to retrieve data:

```
curl -X POST -d "emails[]=test@example.com&emails[]=invalid-email@&emails[]=valid.email@domain.com" http://application.local:81/index.php
```
