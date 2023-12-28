# Описание работы

## 1. Запустите контейнер

```bash
docker compose up -d
```

## 2. Заполните Elasticsearch данными

```bash
curl --location --insecure --request POST 'https://localhost:9200/_bulk' --header 'Authorization: Basic YourToken' --header 'Content-Type: application/json' --data-binary "@books.json"
```

## 3. Выполните поиск

Доступные ключи для поиска:

##### -q : Поиск по заголовку (title)

##### -c : Поиск по категории (category)

##### -l : Поиск по цене ниже введенного значения (price)

### Примеры:

1.

```bash
 php app.php -q рыцорь -c роман -l 1000
```

Ищем по **title** 'рыцорь', **category** 'роман', **price** меньше 2000

2.

```bash
 php app.php -q рыцорь -c роман
```

Ищем по **title** 'рыцорь', **category** 'роман'

3.

```bash
 php app.php -q рыцорь
```

Ищем по **title** 'рыцорь'

4.

```bash
 php app.php -c роман
```

Ищем по **category** 'роман'
