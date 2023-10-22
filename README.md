# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

Примеры команд:
```
# Поиск по title
php public/index.php гроницы

# Поиск по title и строгому соответствую категории category
php public/index.php гроницы "Любовный роман"

# Поиск по title, строгому соответствую категории category и ценой <=|>= указанной
php public/index.php гроницы "Любовный роман" \>=9700

# Поиск по title, строгому соответствую категории category, ценой <=|>= указанной и наличию
# последний аргумент может быть любым
php public/index.php Штирлиц "Исторический роман" \>=700 1
```