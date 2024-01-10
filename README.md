# ElasticSearch

Запуск PHP-CLI контейнера.
Обязательно указать --network, иначе не увидит Elastic.
````
docker run --rm -v ${PWD}/www:/www --network homework_otus-network -it cli php console.php
````

Загрузка данных в индекс:
````
console.php load
````

Поиск:
````
console.php find
````

Пример запроса для поиска:
````
docker run --rm -v ${PWD}/www:/www --network homework_otus-network -it cli php console.php find --title="рыцОри" --category="Исторический" --price="<2000" --stock=">=1"
````

Скрин ответа (начало таблицы):
![img.png](img.png)
