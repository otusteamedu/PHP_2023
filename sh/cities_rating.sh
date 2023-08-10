#!/bin/bash

# считываем города из файла и сортируем их
cities=$(awk 'NR>1 {print $3}' cities_table.txt | sort)

# подсчитываем количество пользователей в каждом городе
counts=$(echo "$cities" | uniq -c)

# сортируем по убыванию количества пользователей
sorted=$(echo "$counts" | sort -nr)

# выводим первые три города
echo "$sorted" | head -n 3 | awk '{print $2}'
