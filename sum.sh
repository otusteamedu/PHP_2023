#!/usr/bin/env bash

function str_repeat() {
  result=""
  str=$1
  repeat=$2

  for i in $(seq 1 "$repeat")
  do
    result+="$str"
  done

  echo "$result"
}

if [ $# -ne 2 ]; then
  echo "Ошибка: необходимо ввести два аргумента. Оба аргумента должны быть числом."
  exit 1
fi

a=$1
b=$2
isIntRegExp='^[+-]?[0-9]+$'
isNumberRegExp='^[+-]?[0-9]+[\.]?[0-9]*$'

if ! [[ $a =~ $isNumberRegExp ]] || ! [[ $b =~ $isNumberRegExp ]]; then
  echo "Ошибка: Оба аргумента должны быть числом"
  exit 1
fi

#если оба числа целые
echo "$a $b" | awk '{c=$1+$2; printf "Сумма %s", c}'
