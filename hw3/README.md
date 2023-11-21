# Поисковый запрос в Google

## Требования
- PHP 7.4

## Установка
```bash
$ composer require vyacheslavshabanov/parsing
```

## Использование
```php
$searchGoogle = new VyacheslavShabanov\Parsing\Search\Site('штаны');
echo $searchGoogle->run();
```

## Зависимости от сторонних библиотек
- guzzlehttp/guzzle
