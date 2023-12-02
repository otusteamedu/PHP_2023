```markdown
# Email Checker Application

Email Checker приложение - это инструмент, позволяющий проверять валидность email адресов. Оно поддерживает два режима работы:

1. Интерактивный ввод списка email и проверка их на валидность.
2. API `/api/check_emails`

## Работа с EmailChecker class 

Класс `Dshevchenko\Emailchecker\Checker` реализует основной функционал приложения:

* Метод `check(string $email): bool` проверяет, является ли предоставленный адрес электронной почты действительным, и сохраняет результат в кэше.
* Метод `getLastDescription(): string` возвращает описание ошибки последнй проверки.

## Пример использования

```php
use Dshevchenko\Emailchecker\Checker;

$checker = new Checker();
$email = 'test@example.com';

$result = $checker->check($email);

if ($result) {
    echo "Email {$email} valid.";
} else {
    echo "Email {$email} not valid: ". $checker->getLastDescription();
}
```

## API endpoint

Отправьте POST-запрос к `/api/check_emails` с телом запроса, содержащим индексированный массив emails:

```json
{
  "emails": ["first@example.com", "second@example.net"]
}
```

В ответ вы получите именованный массив, где ключ - это email, а значение - результат проверки (true или false):

```json
{
  "first@example.com": true,
  "second@example.net": false
}
```
```
