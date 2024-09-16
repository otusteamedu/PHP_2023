# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Задание

Решить задачу https://leetcode.com/problems/merge-two-sorted-lists/ на слияние двух списков


## Описание/Пошаговая инструкция выполнения домашнего задания:
- Решаем задачу
- Прикладываем код на GitHub
- Обосновываем сложность

## Критерии оценки:
- Решение имеет оптимальную сложность
- Учтены исключительные случаи
- Решение проходит тесты

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

После чего выполните команду

```bash
sudo docker compose up -d
```

Для проверки алгоритма запустите следующую команду:
```bash
sudo docker container exec -it myapp-php-dev bash -c "cd /data/www && php console/app.php"
```
