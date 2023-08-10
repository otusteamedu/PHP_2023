#!/bin/bash

read -p "Введите путь к файлу ( /Users/ivan/PhpstormProjects/PHP_2023/hw2/src/db/users.txt ): " path
awk '{print $3}' "$path" | sort | uniq -c | sort -rn | head -3
