# Процессор строк

Краткое описание пакета.

## Требования

- PHP 7.4

## Установка

```bash
$ composer require dmitrykirillov/otus-composer-package
```

## Использование

```php
<?php
$processor = new StringProcessor();
echo $processor->getLength('my string'); // 9  
```
