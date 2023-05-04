#!/bin/bash
REGEXP='^-?[0-9]+([,][0-9]+)?'
if [ $# != 2 ]; then
  echo "Введите 2 числа"
  exit 1
elif [[ ! $1 =~ $REGEXP ]] || [[ ! $2 =~ $REGEXP ]]; then
  echo "Вы дали неправильные аргументы. Введите 2 числа"
  exit 1
else
  echo $1 $2 | awk '{print $1 + $2}'
  exit 0
fi