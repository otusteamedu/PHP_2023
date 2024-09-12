# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Задание

## Описание/Пошаговая инструкция выполнения домашнего задания

Спроектируйте схему данных для системы управления кинотеатром

* Кинотеатр имеет несколько залов, в каждом зале идет несколько разных сеансов, клиенты могут купить билеты на сеансы
* Спроектировать базу данных для управления кинотеатром
* Задокументировать с помощью логической модели
* Написать DDL скрипты
* Написать SQL для нахождения самого прибыльного фильма

Обратите внимание на то, что мы проектируем систему из реального мира. Попробуйте посмотреть на то, как устроена система покупки билета в кинотеатре.

* Все ли сеансы и места стоят одинаково?
* Как может выглядеть схема зала?

Критерии оценки:

* Достаточность таблиц и связей между ними;
* Выполнение правил нормализации;
* Наличие логической модели;
* Указание типов данных в логической модели.

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
cd /vagrant/application && cp .env.example .env
```

Далее, заполните все пустые строки нужными данными в файле `.env`

Перед запуском контейнеров, командой ниже обратите внимание на это уточнение:

Если ранее вами уже создавались контейнеры в этом окружении, то нужно удалить `volume` базы данных, для того, чтобы новые данные корректно добавились. Для этого проверьте наличие этого `volume`

```bash
sudo docker volume ls | grep 'myapp-dbvolume'
```

Если он есть, выполните следующую команду:

```bash
sudo docker volume rm <название из результата выше>
```

После чего можете запускать команду:

```bash
sudo docker compose up -d
```
