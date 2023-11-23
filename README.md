# PHP_2023

Краткое описание пакета

## Требвания

- PHP 7.4

## Установка

```bash
$ composer require vladimirpetrov/otus-string-helper
```

## Использование

```php
<?php
use Vladimirpetrov\OtusStringHelper\StringHelper;

// ...

$val = '123 456,78';
$floatVal = StringHelper::clearFloatVal($val);
echo $floatVal; // 123456.78
```
