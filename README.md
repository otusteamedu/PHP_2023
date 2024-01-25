# Redis

Консольное приложение.
Используется класс RedisService, вместо него можно подключить любой другой с имплементацией интерфейса AnalyticInterface.

В Redis используются сортированное множество для хранения рейтинга и хеши для хранения параметров.


Загрузка данных из файла data.json:
````
docker run --rm -v ${PWD}/www:/www --env-file ${PWD}/.env  --network homework_otus-network -it cli php console.php analytic:import
````

Поиск записи с максимальным рейтингом и заданными параметрами:
````
docker run --rm -v ${PWD}/www:/www --env-file ${PWD}/.env  --network homework_otus-network -it cli php console.php analytic:search
````
Запрос с указанием кол-ва возвращаемых событий:
````
docker run --rm -v ${PWD}/www:/www --env-file ${PWD}/.env  --network homework_otus-network -it cli php console.php analytic:search --limit=2
````
![img.png](img.png)

Параметры задаются в console.php.

