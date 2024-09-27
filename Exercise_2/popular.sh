#! /bin/bash

# Путь к файлу с таблицей
FILE_PATH="./Exercise_2/table.txt"

# Извлекаем города из таблицы, считаем количество вхождений и выводим три наиболее популярных города
POPULAR_CITIES=$(cat "${FILE_PATH}" | awk 'NR>1{print $3}' | sort | uniq -c | sort -rn | head -3)

# Выводим результата
i=1
while read -r line; do
    city=$(echo "${line}" | awk '{print $2}')
    count=$(echo "${line}" | awk '{print $1}')
    echo "1. ${i} - ${city}, пользователей: ${count}"
    i=$((i + 1))
done <<<"${POPULAR_CITIES}"
