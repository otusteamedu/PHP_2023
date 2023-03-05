# Homework 5

Валидатор E-Mail адреса.

## Пример использования:

```php
$validator = new EmailValidator();

try {
    $validator->validate($email);
    
    echo sprintf('✅ "%s" валидный.', $email);
} catch (EmptyEmailAddressException $e) {
    echo sprintf('❌ "%s" пустой.', $email);
} catch (InvalidEmailAddressException $e) {
    echo sprintf('❌ "%s" невалидный.', $email);
} catch (EmptyMxRecordsException $e) {
    echo sprintf('❌ "%s" без MX-записи.', $email);
}
```
