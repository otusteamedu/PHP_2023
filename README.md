
## Развертывание

1. Перейти в корень проекта  
`cd project`
2. Запустить контейнеры  
`docker-compose up -d`
3. Создать структуру БД. Для этого нужно импортировать schema.sql в контейнер sk-mysql  
`cat install/schema.sql | docker exec -i sk-mysql /usr/bin/mysql -u root --password=example balance`
4. Для выполнения команд подключиться к контейнеру приложения
`docker exec -it sk-app bash`
5. Для проверки базы данных в другом окне терминала подключиться к контейнеру БД `docker exec -it sk-mysql bash` .
Зайти в mysql `mysql -uroot -pexample` , выбрать БД `use balance` .

## Выполнение

6. Команды импорта выполняются в контейнере **_sk-app_**. Сами файлы csv находятся в папке **_app/data_**  

`php command.php import positions.csv`  
`php command.php import employees.csv`  
`php command.php import timesheet.csv`  

7. Команды вывода сотрудников, таймшитов по сотруднику и удаления записи таймшита по идентификатору  

`php command.php list employee`  
`php command.php get Jonah`  
`php command.php remove 96`

8. Команды получения и вывода отчётов  

`php command.php report top5longTasks`  

В рамках этой команды на ORM реализован следующий SQL-запрос
`SELECT SUM(ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600)) AS spent_hours, tasks.title FROM timesheets LEFT JOIN tasks ON timesheets.task_id=tasks.id GROUP BY task_id ORDER BY spent_hours DESC LIMIT 5;`  

`php command.php report top5costTasks`  

В рамках этой команды на ORM реализован следующий SQL-запрос
`SELECT SUM( ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600) * (SELECT positions.rate FROM employees JOIN positions ON employees.position_id = positions.id WHERE employees.id = timesheets.employee_id) ) AS total_cost, tasks.title FROM timesheets LEFT JOIN tasks ON task_id=tasks.id GROUP BY task_id ORDER BY total_cost DESC LIMIT 5;`  

`php command.php report top5employees`  

В рамках этой команды на ORM реализован следующий SQL-запрос  
`SELECT SUM(ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600)) AS total_hours, employees.name FROM timesheets LEFT JOIN employees ON employee_id=employees.id GROUP BY employee_id ORDER BY total_hours DESC LIMIT 5;`  

9. Сохранение истории изменений для таблицы таймшитов  

В рамках выполнения задачи создана таблица timesheet_history и триггер timesheet_delete на удаление записи из таблицы timesheets (см. схему **_install/schema.sql_** )
