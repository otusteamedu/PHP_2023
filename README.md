# PHP_2023 
## Timerkhanov A.D. HW 17 - Testing (Unit-тестирование)

---

### Модульные тесты

#### Валидация параметров формы отплаты.

Поле `card_number`

| Назначение теста  | Входные данные                    | Результат   |
|-------------------|-----------------------------------|-------------|
| Проверка длины    | передано более 16 цифр            | код 400     |
| Проверка длины    | передано менее 16 цифр            | код 400     |
| Валидность данных | передано 16 произвольных символов | код 400     |
| Валидность данных | передано 16 цифр                  | **код 200** |

Поле `card_holder`

| Назначение теста  | Входные данные                                               | Результат   |
|-------------------|--------------------------------------------------------------|-------------|
| Валидность данных | переданы латинские буквы без пробелов                        | код 400     |
| Валидность данных | переданы латинские буквы с пробелом в начале строки          | код 400     |
| Валидность данных | переданы латинские буквы с пробелом в конце строки           | код 400     |
| Валидность данных | переданы латинские буквы несколькими пробелами внутри строки | код 400     |
| Валидность данных | переданы произвольные символы с одним пробелом внутри строки | код 400     |
| Валидность данных | переданы латинские буквы с одним пробелом внутри строки      | **код 200** |
| Валидность данных | переданы латинские буквы с одним дефисом внутри строки       | **код 200** |

Поле `card_expiration`

| Назначение теста  | Входные данные                | Результат   |
|-------------------|-------------------------------|-------------|
| Валидность данных | передан невалидный месяц      | код 400     |
| Валидность данных | передан невалидный год        | код 400     |
| Валидность данных | переданы валидные месяц и год | **код 200** |

Поле `cvv`

| Назначение теста  | Входные данные                                      | Результат   |
|-------------------|-----------------------------------------------------|-------------|
| Проверка длины    | передано более 3 цифр                               | код 400     |
| Проверка длины    | передано менее 3 цифр                               | код 400     |
| Валидность данных | передано 3 произвольных символа                     | код 400     |
| Валидность данных | передано 3 цифры                                    | **код 200** |

Поле `order_number`

| Назначение теста  | Входные данные                          | Результат   |
|-------------------|-----------------------------------------|-------------|
| Проверка длины    | передано более 16 произвольных символов | код 400     |
| Проверка длины    | передано менее 16 произвольных символов | код 400     |
| Валидность данных | передано 16 произвольных символов       | **код 200** |

Поле `sum`

| Назначение теста  | Входные данные                                      | Результат   |
|-------------------|-----------------------------------------------------|-------------|
| Валидность данных | переданы произвольные символы                       | код 400     |
| Валидность данных | переданы цифры с запятой в начале строки            | код 400     |
| Валидность данных | переданы цифры с запятой в конце строки             | код 400     |
| Валидность данных | переданы цифры с несколькими запятыми внутри строки | код 400     |
| Валидность данных | переданы цифры с одной запятой внутри строки        | **код 200** |
| Валидность данных | переданы только цифры                               | **код 200** |

#### Валидация целостности формы оплаты

| Назначение теста | Входные данные                    | Результат   |
|------------------|-----------------------------------|-------------|
| Валидность формы | отсуствует поле `card_number`     | код 400     |
| Валидность формы | отсуствует поле `card_holder`     | код 400     |
| Валидность формы | отсуствует поле `card_expiration` | код 400     |
| Валидность формы | отсуствует поле `cvv`             | код 400     |
| Валидность формы | отсуствует поле `sum`             | код 400     |
| Валидность формы | отсуствует поле `order_number`    | код 400     |
| Валидность формы | присутствуют все поля             | **код 200** |

### Интеграционные тесты

#### Тестирование связки "фронт-бэк"

| Входные данные                                                   | Результат                                                         |
|------------------------------------------------------------------|-------------------------------------------------------------------|
| На бэк передан номер карты менее 16 цифр                         | На фронте номер карты выделяется красной рамкой                   |
| На бэк передан валидный номер карты                              | На фронте номер карты выделяется зеленым                          |
| На бэк передано имя держателя карты без фамилии                  | На фронте держатель карты выделяется красной рамкой               |
| На бэк переданы имя и фамилия держателя карты латинскими буквами | На фронте держатель карты выделяется зеленым                      |
| На бэк передан невалидный год                                    | На фронте поле со сроком действия карты выделяется красной рамкой |
| На бэк переданы валидные месяц и год                             | На фронте поле со сроком действия карты выделяется зеленым        |
| На бэк не передано поле `cvv`                                    | На фронте поле `cvv` выделяется красной рамкой                    |
| На бэк передано поле `cvv`                                       | На фронте поле `cvv` выделяется зеленым                           |
| На бэк не передана сумма платежа                                 | На фронте сумма платежа выделяется красной рамкой                 |
| На бэк передана сумма платежа                                    | На фронте сумма платежа выделяется зеленым                        |

#### Тестирование связки "бэк-сервис А"

| Входные данные                                                                                              | Результат                   |
|-------------------------------------------------------------------------------------------------------------|-----------------------------|
| В сервис А переданы платежные данные с некорректным 'cvv'                                                   | На бэк приходит код 403     |
| В сервис А переданы корректные платежные данные с минимальной поддерживаемой сервисом суммой (больше нуля)  | На бэк приходит **код 200** |

#### Тестирование связки "бэк-репозиторий"

| Входные данные                                                      | Результат                  |
|---------------------------------------------------------------------|----------------------------|
| В репозиторий передается некорректная связка `order_number` и `sum` | На бэк приходит исключение |
| В репозиторий передается корректная связка `order_number` и `sum`   | На бэк приходит **true**   |

### Системные тесты

| Входные данные                                                                     | Результат                                                             |
|------------------------------------------------------------------------------------|-----------------------------------------------------------------------|
| С фронта уходит платежная информация с истекшим строком действия карты             | На фронте отображется уведомление о некорректных платежных реквизитах |
| С фронта уходит корректная платежная информация с минимальной суммой (больше нуля) | На фронте отображется уведомление об успешной оплате                  |

