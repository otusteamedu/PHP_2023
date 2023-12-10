# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus  

В основу задачи легло создание абстрактной заявки, в которой есть сообщение и email.  
В качестве фреймворка используется Slim 4.  
При создании заявки методом POST `http://127.0.0.1/application_form`  
создается запись в БД и отправляется сообщение в очередь.  
Схема базы в каталоге `app/database`.  
  
Consumer запускается так: `root@d180a1db6f0a:/data/src/Infrastructure/Queues/Consumer# php consumer.php`.  
Он считывает сообщение из очереди и отправляет email.  
В коде заглушка с принтом, так нет параметров подключения к почтовому серверу.  
