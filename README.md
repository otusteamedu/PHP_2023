## База данных кинотеатра
### Собрать докер контейнер
```bash
docker compose up -d
```
### Запустить скрипты
- sql-scripts/create_tables.sql создание таблиц/связей
- sql-scripts/fill_data.sql заполнение тестовыми данными
- sql-scripts/best_seller.sql выбор фильма бестселлера (по фактически купленными билетам)
#### Особенности структуры базы данных
- поддерживает разделение на залы, сеансы
- билеты могут быть разделены на обычные и vip
- билеты могут бронироваться, но не выкупаться