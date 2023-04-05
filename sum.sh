#!/bin/bash
REGEXP='^-?[0-9]+([.][0-9]+)?$'
if [ $# -ne 2 ]; then
  echo "Введите два значения"
  exit 1
elif [[ ! $1 =~ $REGEXP ]] || [[ ! $2 =~ $REGEXP ]]; then
  echo "Не являются числом $1 или $2"
  exit 1
elif [[ $3 ]]; then
  echo "Максимум 2 числа"
  exit 1
else
  echo $(echo $1 + $2 | bc)
  exit 0
fi
