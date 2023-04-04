# Homework 5

Валидатор E-Mail адреса.

## Пример использования:

```php
$validator = new EmailValidator();

foreach ($emails as $email) {
    try {
        $validator->validate($email);

        echo sprintf('✅ "%s" валидный.', $email) . PHP_EOL;
    } catch (ValidationException $e) {
        echo sprintf('❌ "%s" - %s', $email, $e->getMessage()) . PHP_EOL;
    }
}
```
