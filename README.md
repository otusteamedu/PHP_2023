# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Задание

Необходимо создать свой пакет.

В pull-request прислать composer.json, в котором приводится пример подключения вашего пакета.

## Критерии оценки:
* Пакет должен ставиться при помощи
* composer require package-name
* Пакет должен отвечать PSR-4
* Пакет может подключаться в Composer либо с packagist, либо из GitHub
* 4 балла за соответствие PSR-4
* 3 балла успешное подключение к пакету
* 3 балла за корректность содержимого пакета

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

Перейдите в php котейнер
```bash
sudo docker container exec -it myapp-php bash
```

И запустите composer
```bash
cd /data/www && composer install
```

Добавьте сайт `mysite.local` в файл `hosts`
```bash
127.0.0.1 mysite.local
```

Перейдите по ссылке http://mysite.local
