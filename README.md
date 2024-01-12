# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

### Реализация домашнего задания

`35 Deploy приложений`

В файле `.github/workflows/deploy.yml` описаны gutHub Actions
Текущее описание работает так
- происходит пуш коммита
- - в наблюдаемую ветку `TARGET_BRANCH='NDybnov/hw21'`
- - репозитория `REPOSITORY='https://github.com/otusteamedu/PHP_2023.git'`

- до выполнения deploy репозитория на сервер запрашивается версия приложения
```shell
Run curl 5.35.98.239
% Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
Dload  Upload   Total   Spent    Left  Speed

0     0    0     0    0     0      0      0 --:--:-- --:--:-- --:--:--     0
100    94    0    94    0     0    356      0 --:--:-- --:--:-- --:--:--   357
8.3.1:c1334aaa5095f47c59bd32074d6cb9606c225d6e:add_show_version_before_and_after_server_update
```
в данном случае
- -  `c1334aaa5095f47c59bd32074d6cb9606c225d6e` хеш-код крайнего коммита наблюдаемой ветки
- - `add_show_version_before_and_after_server_update` комментарий (без пробелов)
- далее через gitHub Action отправляется сообщение серверу для получения изменений из репозитория
- после выполнения обновления на сервере, снова запрашивается версия приложения на сервере, для подтверждения обновления
```shell
Run curl 5.35.98.239
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed

  0     0    0     0    0     0      0      0 --:--:-- --:--:-- --:--:--     0
100    59    0    59    0     0    225      0 --:--:-- --:--:-- --:--:--   225
8.3.1:72cb4164c1be0edb068c9bc6f553e2c071542a6a:second_check
```
- - `72cb4164c1be0edb068c9bc6f553e2c071542a6a` хеш коммита
- - `second_check` комментарий коммита

Пример взят по ссылке https://github.com/otusteamedu/PHP_2023/actions/runs/7497950472/job/20412327150


Официальная информация https://docs.github.com/en/rest/deployments/deployments?apiVersion=2022-11-28
