# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Задание

Docker 
1. Установить Docker себе на локальную машину
2. Описать инфраструктуру в Docker-compose, которая включает в себя 
3. nginx (обрабатывает статику, пробрасывает выполнение скриптов в fpm)
4. php-fpm (соединяется с nginx через unix-сокет)
5. redis (соединяется с php по порту)
6. memcached (соединяется с php по порту)
7. БД подключать как отдельную VM (можно на базе Homestead), либо как контейнер (но тогда не забудьте про директории с данными)
8. Не забудьте про Composer

# Установка

## Изолированное окружение

Для развёртывания изолированного окружения пропишите команду
```bash
vagrant up
```

После установки, зайдите в ОС
```bash
vagrant ssh
```

## Подготовка и запуск среды
```bash
cd application && cp .env.example .env
```

Далее, заполните все пустые строки нужными данными в файле `.env`

После чего выполните команду

```bash
sudo docker compose up -d
```

Добавьте сайт `mysite.local` в файл `hosts`
```bash
127.0.0.1 mysite.local
```

Готово!
