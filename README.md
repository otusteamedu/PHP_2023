### Реализация домашнего задания

Приложение верификации email

Инструкция по установке, настройки и использованию приложения верификации email.
-- --
#### Настройка

* создание файла конфигурации для запуска docker-контейнеров
```shell
cp ./.env.example ./.env
```

* создание файла конфигурации для использования приложения
```shell
cp ./src/config.ini.example ./src/config.ini
```

* Собрать и запустить docker-контейнеры
```shell
docker-compose up --build
```

* установка composer-зависимостей
```shell
  docker exec -ti php-fpm-emails composer install
```

Теперь приложение готово к использованию.
-- --
#### Использование

В браузере открывается главная страница

* примерно с таким содержимом, проверяемый список email указан в файле `config.ini`
```
Emails: correct@mail.ru,er@mail.!ru,aa@qq,aa@q,aa@qq.q,box@mail.ru,aa@mail.qq

Message-errors(11):
[filter_var] ~ [er@mail.!ru] :: Incorrect value `er@mail.!ru` by rule `filter_var`.
[reg_exp] ~ [er@mail.!ru] :: Incorrect value `er@mail.!ru` by rule `reg_exp`.
[external_dns_mx] ~ [er@mail.!ru] :: Incorrect value `er@mail.!ru` by rule `external_dns_mx`.
[filter_var] ~ [aa@qq] :: Incorrect value `aa@qq` by rule `filter_var`.
[reg_exp] ~ [aa@qq] :: Incorrect value `aa@qq` by rule `reg_exp`.
[external_dns_mx] ~ [aa@qq] :: Incorrect value `aa@qq` by rule `external_dns_mx`.
[filter_var] ~ [aa@q] :: Incorrect value `aa@q` by rule `filter_var`.
[reg_exp] ~ [aa@q] :: Incorrect value `aa@q` by rule `reg_exp`.
[external_dns_mx] ~ [aa@q] :: Incorrect value `aa@q` by rule `external_dns_mx`.
[external_dns_mx] ~ [aa@qq.q] :: Incorrect value `aa@qq.q` by rule `external_dns_mx`.
[external_dns_mx] ~ [aa@mail.qq] :: Incorrect value `aa@mail.qq` by rule `external_dns_mx`.
```

* или указать дополнительный параметр `emails` в get-запросе в браузере
`http://app.local:8181/?emails=aa@qq,aa@q,aa@qq.q,box@mail.ru,aa@mail.qqq`
```
Emails: aa@qq,aa@q,aa@qq.q,box@mail.ru,aa@mail.qqq

Message-errors(8):
[filter_var] ~ [aa@qq] :: Incorrect value `aa@qq` by rule `filter_var`.
[reg_exp] ~ [aa@qq] :: Incorrect value `aa@qq` by rule `reg_exp`.
[external_dns_mx] ~ [aa@qq] :: Incorrect value `aa@qq` by rule `external_dns_mx`.
[filter_var] ~ [aa@q] :: Incorrect value `aa@q` by rule `filter_var`.
[reg_exp] ~ [aa@q] :: Incorrect value `aa@q` by rule `reg_exp`.
[external_dns_mx] ~ [aa@q] :: Incorrect value `aa@q` by rule `external_dns_mx`.
[external_dns_mx] ~ [aa@qq.q] :: Incorrect value `aa@qq.q` by rule `external_dns_mx`.
[external_dns_mx] ~ [aa@mail.qqq] :: Incorrect value `aa@mail.qqq` by rule `external_dns_mx`.
```
-- --
