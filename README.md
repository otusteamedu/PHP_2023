# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus


1. Приложение верификации email
2. Реализовать приложение (сервис/функцию) для верификации email.
3. Реализация будет в будущем встроена в более крупное решение.
4. Минимальный функционал - список строк, которые необходимо проверить на наличие валидных email.
5. Валидация по регулярным выражениям и проверке DNS mx записи, без полноценной отправки письма-подтверждения.

```bash
curl --location 'http://application.local/verifyEmail' \
--form 'emails[]="test@mail.ru"' \
--form 'emails[]="test@ya.ru"' \
--form 'emails[]="test@em.ru"'
```




