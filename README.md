# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Примеры команд:
### Поиск по title
```php index.php -s женщины```
### Поиск по title и строгому соответствую категории category
```php index.php -s гроницы -c "Любовный роман"```
### Поиск по title, строгому соответствую категории category и ценой <=|>= указанной
```php index.php -s гроницы -c "Любовный роман" -p \>=9700```
### Поиск по title, строгому соответствую категории category, ценой <=|>= указанной и наличию
### Последний аргумент может быть любым
```php index.php -s Штирлиц -c "Исторический роман" -p \>=700 -q 1```
