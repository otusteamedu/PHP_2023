#!/bin/bash

# обрабатываем входную строку
input=$1
input=${input//,/.} # заменяем запятую на точку для корректного чтения дробных чисел

if ! [[ "$input" =~ ^[0-9\.\+\-]*$ ]]; then
  echo "Error: Invalid input"
  exit 1
fi

# сложение чисел
result=$(echo "$input" | bc -l)

echo "$result"
