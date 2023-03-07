# Получение названия месяца по его номеру

## Требования
- PHP 7.4

## Установка

```bash
$ composer require nartamomonov/otus_hw3_month_name
```

## Использование

```php
<?php
$processor = new MonthProcessor();
echo processor->getMonthName(1); // Январь
```