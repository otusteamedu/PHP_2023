# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Задание

- Развернуть Homestead VM при помощи Vagrant и VirtualBox
- Сайт должен отвечать на доменное имя application.local
- Должна быть поддержка проброса директорий

# Установка

Развернуть изолированное окружение при помощи команды

```bash
vagrant up
```

добавить 

```bash
127.0.0.1 application.local
```

в файл `hosts`