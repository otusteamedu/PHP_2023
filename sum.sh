#!/usr/bin/env bash

if [ $# -ne 2 ]; then
  echo "Ошибка: необходимо ввести два аргумента. Оба аргумента должны быть числом."
  exit 1
fi

a=$1
b=$2
isIntRegExp='^[+-]?[0-9]+$'
isNumberRegExp='^[+-]?[0-9]+[\.]?[0-9]?$'

if ! [[ $a =~ $isNumberRegExp ]] || ! [[ $b =~ $isNumberRegExp ]]; then
  echo "Ошибка: Оба аргумента должны быть числом"
  exit 1
fi

#если оба числа целые
if [[ $a =~ $isIntRegExp ]] && [[ $b =~ $isIntRegExp ]]; then
  echo "Сумма "$(($a+$b))
  exit 0
else
  c=$(echo "$a+$b" | bc) || {
      echo "Ошибка выполнения скрипта, проверьте наличи bc"
      exit 1
  }

  echo "Сумма $c"
fi
