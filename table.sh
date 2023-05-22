#!/bin/bash

# Указываем путь к файлу с таблицей
file="table.txt"

# Используем утилиты Linux для обработки таблицы и получения наиболее популярных городов
result=$(awk '{if ($3 != "city") print $3}' "$file" | sort | uniq -c | sort -k1,1rn -k2,2 | head -n 3 | awk '{print $2}')

# Переменная для нумерации
counter=1

# Выводим результат на экран с нумерацией
echo "Наиболее популярные города:"
while read -r city; do
    echo "$counter. $city"
    counter=$((counter+1))
done <<< "$result"

