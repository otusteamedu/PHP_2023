#!/bin/bash

# Имеется таблица следующего вида (файл :
# id user city phone
# 1 test Moscow 1234123
# 2 test2 Saint-P 1232121
# 3 test3 Tver 4352124
# 4 test4 Milan 7990923
# 5 test5 Moscow 908213
# Таблица хранится в текстовом файле.

# Вывести на экран 3 наиболее популярных города среди пользователей системы, используя утилиты Линукса.
# Подсказка: рекомендуется использовать утилиты uniq, awk, sort, head.

file='table.txt'
tail +2 $file | awk '{print $3}' | sort -k 1 | uniq -c | sort -rn  | head -3
