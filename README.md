## Требования

- PHP 7.4 или выше

## Установка

```bash
$ composer require sekaiichi/super_app
```

## Использование

```php
<?php
$searchProduct = new SearchProductAction();
$products = $searchProduct('iphone'); 
foreach ($products as $product) {
    echo $product['name'];
}
```