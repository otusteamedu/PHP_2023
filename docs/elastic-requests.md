### Создание индекса
```http request
PUT /book-shop
```
### Добавление нового документа в индекс
```
POST /book-shop/_doc            - присвоит id автоматически
POST /book-shop/create/<_id>    - требует указания уникального id
```
### Получение документа из индекса
```
GET /book-shop/_doc/<_id>       - возвращает исходный json + мета-данные
GET /book-shop/_source/<_id>    - возвращает исходный json
```
### Обновление документа в индексе
```http request
POST /book-shop/update/<_id>
Content-Type: application/json

{
    "doc": {
       "price": 2500
    }
}
```
### Удаление документа из индекса
```http request
DELETE /book-shop/_doc/<_id>
```
### Массовое добавление/изменение документов
```http request
POST /_bulk

{"create": {"_index": "book-shop", "_id": "342-001"}}
{ ...JSON... }
{"update": {"_index": "book-shop", "_id": "342-001"}}
{ ...JSON... }
{"delete": {"_index": "book-shop", "_id": "342-001"}}
```
```
curl \
    --location \
    --insecure \
    --request POST 'https://localhost:9200/_bulk' \
    --header 'Authorization: Basic ZDddfsewerdgw45d==' \
    --header 'Content-Type: application/json' \
    --data-binary "@bulk.json"
```
### Посмотреть типы полей
```http request
GET /book-shop/_mapping
```
### Поиск: все результаты
```http request
GET /book-shop/_search

{
    "query": {
        "match_all": { }
    }
}
```
### Поиск с сортировкой
```http request
GET /book-shop/_search

{
    "sort": [
        {"price": "desc"}
    ],
    "query": {
        "match_all": { }
    }
}
```
### Поиск с сортировкой и пагинацией
```http request
GET /book-shop/_search

{
    "from": 10,
    "size": 20,
    "sort": [
        {"price": "desc"}
    ],
    "query": {
        "match_all": { }
    }
}
```
### Поиск: полнотекстовый поиск
```http request
GET /book-shop/_search

{
    "query": {
        "match": {
            "title": "война и мир"
        }
    }
}
```
### Поиск: точное совпадение
```http request
GET /book-shop/_search

{
    "query": {
        "term": {
            "category": "роман"
        }
    }
}
```
### Поиск по терминам
```http request
GET /book-shop/_search

{
    "query": {
        "term": {
            "category.keyword": "роман"
        }
    }
}
```
### Поиск: диапазон
```http request
GET /book-shop/_search

{
    "query": {
        "range": {
            "price": {
                "gte": 1200,
                "lt": 1300
            }
        }
    }
}
```
### Поиск: составные запросы 
```http request
GET /book-shop/_search

{
    "query": {
        "bool": {
            "must": [
                { "match": { "title": "мир" },
            ],
            "filter": [
                { "range": { "price": { "gte": 9950 } },
            ]
        }
    }
}
```
### Создание индекса с конкретным mapping-ом
```http request
PUT /book-shop

{
    "mappings": {
        "title": { "type": "text" },
        "sku": { "type": "text" },
        "category": { "type": "keyword" },
        "price": { "type": "short" }
        ...
    }
}

{
    "mappings": {
        "properties": {
            "category": {
                "type": "keyword",
            },
            "price": {
                "type": "integer",
            },
            "sku": {
                "type": "keyword",
            },
            "stock": {
                "type": "nested",
                "properties": {
                    "shop": {
                        "type": "keyword"
                    },
                    "stock": {
                        "type": "short"
                    }
                }
            },
            "title": {
                "type": "text",
                "fields": {
                    "keyword": {
                        "type": "keyword",
                        "ignore_above": 256
                    }
                }
            },
            "volume": {
                "type": "float",
            }
        }
    }
}
```
### Поиск по вложенным массивам
```http request
GET /book-shop/_search

{
    "query": {
        "nested": {
            "path": "stock",
            "query": {
                "bool": {
                    "filter": [
                        { "match": { "stock.shop": "Мира" } },
                        { "range": { "stock.stock": { "gte": 15 } } }
                    ]
                }
            }
        }
    }
}
```
### Поиск: полнотекстовый поиск
```http request
GET /book-shop/_search

{
    "query": {
        "match": {
            "content": "ООО",
        }
    }
}
```
### Поиск: анализаторы
```http request
GET /book-shop/_search

{
    "settings": {
        "analysis": {
            ...
            "analyzer": {
                "my_russian": {
                    "filter": [ "lowercase", "ru_stop", "ru_stemmer" ]
                }
            }
        }
    }
}
```
### Создание индекса с анализаторами
```http request
GET /book-shop/_search

{
    "settings": {
        "analysis": {
            "filter": {
                "ru_stop": {
                    "type": "stop",
                    "stopwords": "_russian_"
                },
                "ru_stemmer": {
                    "type": "stemmer",
                    "language": "russian"
                }
            },
            "analyzer": {
                "my_russian": {
                    "tokenizer": "standard",
                    "filter": [
                        "lowercase",
                        "ru_stop",
                        "ru_stemmer"
                    ]
                }
            }
        }
    },
    "mappings": {
        "properties": {
            "content": {
                "type": "text",
                "analyzer": "my_russian"
            }
        }
    }
}
```
### Полнотекстовый поиск: нечеткий поиск (опечатки)
```http request
GET /book-shop/_search

{
    "query": {
        "match": {
            "content": {
                "query": "кансультация",
                "fuzziness": "auto"
            }
        }
    }
}
```