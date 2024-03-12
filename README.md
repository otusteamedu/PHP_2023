# Домашнее задание
Работа с очередью

## Цель:
Мы научимся строить асинхронное приложение на практике.
Задача состоит в том, чтобы научиться применять очередь, увидеть её преимущества и недостатки.

## Описание/Пошаговая инструкция выполнения домашнего задания:
Пишем приложение обработки отложенных запросов.
- Создать простое веб-приложение, принимающее POST запрос из формы от пользователя. Например, запрос на генерацию банковской выписки за указанные даты.
- Обычно такие запросы (в реальных системах) работают довольно долго, поэтому пользователя надо оповестить о том, что запрос принят в обработку
- Форма должна подразумевать отправку оповещения по результатам работы
- Передать тело запроса в очередь
- Написать скрипт, который будет читать сообщения из очереди и выводить информацию о них в консоль
- *Реализация оповещения
    - Сгенерированный ответ отправить через email или telegram
- Приложить инструкцию по запуску системы

## Критерии оценки:
1. Работоспособность решения (5 баллов)
2. Чистота кода (3 балла)
3. Инструкции по развёртыванию системы (2 балла)

## Как проверить
1. Задаем переменные окружения 
2. запускаем `docker-compose up`
3. заходим в контейнер application 
4. запускаем `composer install`
5. Отправляем запрос на формирование выписки

Примеры запроса на формирование выписки:
```bash
curl --request POST \
  --url http://127.0.0.1/api/v1/bank_statement \
  --header 'content-type: multipart/form-data' \
  --form 'startDate=2024-01-01 00:00:00' \
  --form 'endDate=2024-03-10 23:59:59' \
  --form type=3 \
  --form userId=777

curl --request POST \
  --url http://127.0.0.1/api/v1/bank_statement \
  --header 'content-type: multipart/form-data' \
  --form 'startDate=2024-01-01 00:00:00' \
  --form 'endDate=2024-03-10 23:59:59' \
  --form type=3 \
  --form userId=1
  
curl --request POST \
  --url http://127.0.0.1/api/v1/bank_statement \
  --header 'content-type: multipart/form-data' \
  --form 'startDate=2024-01-01 00:00:00' \
  --form 'endDate=2024-03-10 23:59:59' \
  --form type=3 \
  --form userId=2
  
#не существующий id пользователя 
 curl --request POST \
  --url http://127.0.0.1/api/v1/bank_statement \
  --header 'content-type: multipart/form-data' \
  --form 'startDate=2024-01-01 00:00:00' \
  --form 'endDate=2024-03-10 23:59:59' \
  --form type=3 \
  --form userId=7

#не валидные данные  
curl --request POST \
  --url http://127.0.0.1/api/v1/bank_statement \
  --header 'content-type: multipart/form-data' \
  --form startDate= \
  --form 'endDate=2024-03-10 23:59:59' \
  --form type= \
  --form userId=777    
```

Консьюмер запускается supervisor'ом. Логи смотреть тут:
```bash
#вывод из консоли
./var/log/supervisor.order_bank_statement.out.log

#ошибки
./var/log/supervisor.order_bank_statement.error.log
```
