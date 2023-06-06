## Запуск конейтнеров
```shell
docker-compose up -d
```

## Проверка наличия петли в списке
```shell
# Выполнение команд внутри контейнера app
php public/index.php 
```
### Описание
data/htdocs/src/Sva/Common/App/LinkedListUtils.php - тут непосредственно алгоритм

- Создаем два указателя на списки;
- Первый указатель смещаем на 1;
- Второй указатель смещаем на 2;
- Сравниваем указатели. Как только указатель 1 равен указателю 2 считаем что зацикленность присутствует;
- Если указатель 2 достиг конца списка, то зацикленности нет.

## Получение всех возможных комбинаций из нажатых клавиш кнопочного телефона
```shell
# Выполнение команд внутри контейнера app
php public/index.php letter-combinations
```

### Описание
data/htdocs/src/Sva/Common/Domain/PhoneDigests.php - тут непосредственно алгоритм в методе letterCombinations

- Создаем массив с соответствиями цифр и букв в константе
- Создаем массив result с одним элементом в виде пустой строки
- Проверяем не пришла ли пустая строка
- Вытаскиваем все цифры в массив по отдельности
- Бежи по нажатым цифрам
  - Создаем массив результата по текущей цифре 
  - Проверяем является ли цифра \[2-9\]
  - Бежим по массиву result, на первой итерации там всего одна пустая строка 
  - Получаем буквы соответствующие цифре
  - К текущему элементу результата добавляем букву
  - Сливаем массив с результатами для цифры в общий массив result
- Возвращаем результат
