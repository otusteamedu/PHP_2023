#### Импорт данных в ElasticSearch

```shell
docker exec -it imitronov_hw11_app bin/console app:products:import:elastic /var/www/app/storage/books.json
```

#### Поиск товаров

```shell
docker exec -it imitronov_hw11_app bin/console app:products:search -t "рыцОри" -c "Исторический роман" -p 2000
```
