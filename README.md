# PHP_2023_21

Возьмем за основу [hw31](https://github.com/otusteamedu/PHP_2023/tree/APorivaev/hw31) 

Разобьем на следующие директории:
1. `Infrastructure` - внешними системами: БД и очередь.
1. `Application` - пользовательские сценарии и интерфейсы для взаимодействия с `Infrastructure`.
1. `Domain` - сущность и исключения.


## Запуск
1. `docker-compose build php`
2. `docker-compose up`

## Документация
- `doc\api.yaml`
- `doc\doc.html`
