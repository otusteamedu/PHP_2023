# Проверка кода
```shell
docker-compose exec app vendor/bin/phpcs -h
```
## События
Реализовано хранение в redis или elasticsearch.

Для переключения в .env файле нужно изменить значение переменной EVENT_STORAGE на redis или elasticsearch.

## Запуск
```shell
docker-compose up -d
```

## Выолнение команд
```shell
# Команда создает индекс, грузит данные
php public/index.php create-index && php public/index.php load-data

#Команда удаляет
php public/index.php delete-index

# поиск по ДЗ 
php public/index.php search query="рыцОри" price-to="2000" category="Исторический роман" stock-from=10
```
