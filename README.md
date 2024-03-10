# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus


- В основу задачи легло создание абстрактной заявки, в которой есть сообщение и email.  
- фреймворк используется Slim 4.  
- При создании заявки методом POST `http://127.0.0.1/application_form`  
- создается запись в БД, отправляется сообщение в очередь и сообщение на email. `(в коде заглушка, так нет параметров подключения к почтовому серверу)`  
- Схема базы в каталоге `app/database`.

Consumer запускается так: `/app/src/Infrastructure/Queues/Consumer# php consumer.php`.  